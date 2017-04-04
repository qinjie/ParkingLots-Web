__author__ = 'zqi2'

import ConfigParser
import datetime

import requests
from requests.auth import HTTPBasicAuth

from entity import Entity


# car_entry = /traffic-flow/car-entry/<gantry_serial>
# car_exit = /traffic-flow/car-exit/<gantry_serial>
# delete_hours_older = /traffic-flow/delete-hours-older/<hours>
# latest_by_car_park = /traffic-flow/latest-by-car-park/<car_park_id>
# latest_all_car_park = /traffic-flow/latest-all-car-park
# latest_all_car_park_today = /traffic-flow/latest-all-car-park-today
# list-older-than-hours = /traffic-flow/list-older-than-hours


class TrafficFlow(Entity):
    # config section
    _config_section = 'traffic-flow'

    def __init__(self):
        Entity.__init__(self)

        parser = ConfigParser.SafeConfigParser()
        parser.read(self._config_file)
        self._urls['car_entry'] = self._base_url + parser.get(self._config_section, 'car_entry')
        self._urls['car_exit'] = self._base_url + parser.get(self._config_section, 'car_exit')
        self._urls['list_older_than_hours'] = self._base_url + parser.get(self._config_section, 'list_older_than_hours')
        self._urls['clear_days_older'] = self._base_url + parser.get(self._config_section, 'clear_days_older')
        self._urls['latest_by_car_park'] = self._base_url + parser.get(self._config_section, 'latest_by_car_park')
        self._urls['latest_all_car_park'] = self._base_url + parser.get(self._config_section, 'latest_all_car_park')
        self._urls['latest_all_car_park_today'] = self._base_url + parser.get(self._config_section,
                                                                              'latest_all_car_park_today')

    def car_entry(self, gantry_serial, auth=None):
        url = self._urls['car_entry'].replace("<gantry_serial>", str(gantry_serial))
        headers = {'Accept': 'application/json'}
        r = requests.post(url, auth=auth, headers=headers)
        self.log.info("car_entry: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def car_exit(self, gantry_serial, auth=None):
        url = self._urls['car_exit'].replace("<gantry_serial>", str(gantry_serial))
        headers = {'Accept': 'application/json'}
        r = requests.post(url, auth=auth, headers=headers)
        self.log.info("car_exit: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def latest_by_car_park(self, car_park_id, auth=None):
        url = self._urls['latest_by_car_park'].replace("<car_park_id>", str(car_park_id))
        headers = {'Accept': 'application/json'}
        r = requests.get(url, auth=auth, headers=headers)
        self.log.info("latest_by_car_park: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def latest_all_car_park(self, auth=None):
        url = self._urls['latest_all_car_park']
        headers = {'Accept': 'application/json'}
        r = requests.get(url, auth=auth, headers=headers)
        self.log.info("latest_all_car_park: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def latest_all_car_park_today(self, auth=None):
        url = self._urls['latest_all_car_park_today']
        headers = {'Accept': 'application/json'}
        r = requests.get(url, auth=auth, headers=headers)
        self.log.info("latest_all_car_park_today: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def list_older_than_hours(self, hours, auth=None):
        url = self._urls['list_older_than_hours'].replace("<hours>", str(hours))
        headers = {'Accept': 'application/json'}
        r = requests.get(url, auth=auth, headers=headers)
        self.log.info("list_older_than_hours: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

    def clear_days_older(self, days, auth=None):
        url = self._urls['clear_days_older']
        url = url.replace("<days>", str(days))
        r = requests.delete(url, auth=auth)
        self.log.info("clear_days_older: %s", url)
        self.log.info("%s %s", r.status_code, r.headers['content-type'])
        self.log.info(r.text)
        return r

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

    entity = TrafficFlow()
# LIST
entity.list(auth)

# VIEWbWFuYWdlcjE6MTIzNDU2
entity.view(2)

# SEARCH
entity.search('car_park_id=1', auth)

# car_entry & car_exit
serial = "6792b9e854279c65e722"
entity.car_entry(gantry_serial=serial, auth=auth)
serial = "d1bbd4ae664369f83a1a"
entity.car_entry(gantry_serial=serial, auth=auth)
serial = "193a928500e65443a176"
entity.car_entry(gantry_serial=serial, auth=auth)
serial = "22cd9ee4006e4fd873d6"
entity.car_entry(gantry_serial=serial, auth=auth)

serial = "193a928500e65443a176"
entity.car_exit(gantry_serial=serial, auth=auth)
serial = "22cd9ee4006e4fd873d6"
entity.car_exit(gantry_serial=serial, auth=auth)

# latest_by_car_park
car_park_id = "1"
entity.latest_by_car_park(car_park_id)

# latest_by_car_park
entity.latest_all_car_park()

# latest_by_car_park
entity.latest_all_car_park_today()


    # # delete_hours_older
    # username = 'admin'
    # password = '123456'
    # auth = HTTPBasicAuth(username, password)
    #
    # days = 1
    # entity.clear_days_older(days, auth=auth)
