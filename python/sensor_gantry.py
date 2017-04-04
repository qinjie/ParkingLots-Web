__author__ = 'zqi2'

import ConfigParser
import argparse
from requests.auth import HTTPBasicAuth
from entity import Entity


class SensorGantry (Entity):
    # config section
    _config_section = 'sensor-gantry'

    # clear entry_count and exit_count field. Used in daily reset.
    def clear_counter(self, auth):
        list = self.list(auth)
        js = list.json()
        count = 0
        for ent in js['items']:
            ent['entry_count'] = 0
            ent['exit_count'] = 0
            resp = self.update(ent, auth)

            if resp:
                count = count + 1

        self.log.info('Cleared %d records', count)

        return count


if __name__ == '__main__':

    # # Read options from command line
    # argParser = argparse.ArgumentParser('API Entity')
    # argParser.add_argument('-c', '--configFile', help="Configuration file", required=False)
    # argParser.add_argument('-s', '--configSession', help="Configuration session", required=False)
    # argParser.add_argument('-u', '--username', help="Username", required=False)
    # argParser.add_argument('-p', '--password', help="Password", required=False)
    # args = argParser.parse_args()

    # Username and Password for Authentication
    username = 'manager1'
    password = '123456'
    auth = HTTPBasicAuth(username, password)

    entity = SensorGantry()

    # LIST
    r = entity.list(auth)

    # VIEW
    entity.view(1)

    # SEARCH
    entity.search('car_park_id=1', auth)

    # CREATE
    data = {
      "label": "Test-Gantry",
      "serial": "abcdefgh-12345678",
      "car_park_id": "1"
    }

    r = entity.create(data, auth)

    if r.status_code == 201:
        # UPDATE
        obj = r.json()
        obj['label'] = 'Test-Sensor-Gantry'
        obj['car_park_id'] = '2'
        r2 = entity.update(obj, auth)

        # DELETE
        r3 = entity.delete(obj['id'], auth)

    n = entity.clear_counter(auth)


