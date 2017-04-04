from car_park import CarPark
from sensor_gantry import SensorGantry

__author__ = 'zqi2'

from requests.auth import HTTPBasicAuth
from traffic_flow import TrafficFlow

if __name__ == '__main__':
    # Only manager or admin Allowed
    username = 'admin'
    password = '123456'
    auth = HTTPBasicAuth(username, password)

    # Clean TrafficFlow
    tf = TrafficFlow()
    days = 7  # 7 days
    tf.clear_days_older(days=days, auth=auth)

    # Clear CarPark car-counter
    cp = CarPark()
    cp.clear_counter(auth)

    # Clear SensorGantry entry-counter and exit-counter
    sg = SensorGantry()
    sg.clear_counter(auth)
