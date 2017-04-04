# Web Service API for Parking Lots #

Server: http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1


## User Account ##

Some services requires user to login

### User Account Type ###

Type of user account with different level of access
    Admin > Manager > User > anonymous

@ = Any Authenticated Account
* = No authentication required

## Car Park ##

### List of Services ###
list = /car-park
view = /car-park/<id>?expand=gantries,owner
update = /car-park/<id>
delete = /car-park/<id>
create = /car-park
search = /car-park/search?<query>

#### list ####
URL: /car-park?expand=gantries,owner
Method: GET
Remark: List all car parks. Optional to get related gantries and owner (creator) of each car park.
Access: Anonymous

#### view ####
URL: /car-park/<id>?expand=gantries,owner
Method: GET
Remark: View detail info of a car park. Optional to get related gantries and own (creator) of the car park.
Access: Anonymous

#### update = /car-park/<id> ####


#### delete = /car-park/<id> ####


#### create = /car-park ####


#### search = /car-park/search?<query> ####


## Sensor Gantry ##

### List of Services ###
list = /sensor-gantry
view = /sensor-gantry/<id>?expand=carPark
update = /sensor-gantry/<id>
delete = /sensor-gantry/<id>
create = /sensor-gantry
search = /sensor-gantry/search?<query>


## Traffic Flow ##

### List of Services ###
list = /traffic-flow
view = /traffic-flow/<id>?expand=gantry,carPark
update = /traffic-flow/<id>
delete = /traffic-flow/<id>
create = /traffic-flow
search = /traffic-flow/search?<query>
car_entry = /traffic-flow/car-entry/<gantry_serial>
car_exit = /traffic-flow/car-exit/<gantry_serial>
delete_hours_older = /traffic-flow/delete-hours-older/<hours>
latest_by_car_park = /traffic-flow/latest-by-car-park/<car_park_id>
latest_all_car_park = /traffic-flow/latest-all-car-park
latest_all_car_park_today = /traffic-flow/latest-all-car-park-today



