# Parking Lots #

* Server: http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1
* IP Address: 128.199.77.122

## Database ##

![Database Structure](docs/database_schema.png)

__List of Key Database Tables__

Table   | Remark
---     | ---
car_park | A parking area with one or more sensor gantries.
sensor_gantry | A sensor on the road side which can detect entry and/or exit of cars of a car_park
traffic_flow | A event of car entry or exit
user | list of users


---

## User Account ##

Some services requires user to login

### User Account Type ###

Type of user account with different level of access
    Admin \> Manager \> User \> anonymous

@ = Any Authenticated Account
* = No authentication required


---

## Available Web Service ##

__Common Web Service Operations__
Web services are operations for database tables. Basic operations are closely related to database operations. 

Operation   | Remark
---     | ---
List    | List all objects in the table
View    | View an object with its ID
Search  | Search for objects with some conditions
Create  | Create an new object in database
Update  | Update an object identified by ID
Delete  | Delete an object from table
Other Custom Functions  | Customized web service function


## Car Park ##
> A parking area with one or more sensor gantries.

#### list ####
> List all car parks. Optional to get related gantries and owner (creator) of each car park.

* URL: /car-park?expand=gantries,owner
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park?expand=gantries,owner


#### view ####
> View detail info of a car park. Optional to get related gantries and own (creator) of the car park.

* URL: /car-park/<id\>?expand=gantries,owner
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/1
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/1?expand=gantries,owner


#### search ####
> Search for car-parks which fulfils the query condition(s).

* URL: /car-park/search?<query\>
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/search?label=Sports%20Complex
    - space must be replace with %20
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/search?label=Sports%20Complex&status=1


#### create ####
> Create a new car-park

* URL: /car-park
* Method: POST
* Data: {"label": "Test-123",
          "lot_capacity": "9",
          "serial": "abcdefgh-12345678",
          "status": "1",
          "remark": ""}
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park


#### update ####
> Update a car-park with id = <id\>

* URL: /car-park/<id\>
* Method: PUT
* Data: {"label": "Test-123",
          "lot_capacity": "9",
          "serial": "abcdefgh-12345678",
          "status": "1",
          "remark": ""}
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/1


#### delete ####
> Delete a car-park with id = <id\>

* URL: /car-park/<id\>
* Method: DELETE
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/car-park/1



## Sensor Gantry ##
> A sensor on the road side which can detect entry and/or exit of cars of a car_park

#### list ####
> List all sensor gantries. Optional to get related car-park.

* URL: /sensor-gantry?expand=carPark
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry?expand=carPark


#### view ####
> View detail info of a sensor-gantry.  Optional to get related car-park.

* URL: /sensor-gantry/<id\>?expand=carPark
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/1
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/1?expand=carPark


#### search ####
> Search for sensor-gantry which fulfils the query condition(s).

* URL: /sensor-gantry/search?<query>
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/search?label=SP%20A
    - space must be replace with %20
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/search?car_park_id=1


#### create ####
> Create a new sensor-gantry

* URL: /sensor-gantry
* Method: POST
* Data: {  "label": "Test-Gantry",
           "serial": "abcdefgh-12345678",
           "car_park_id": "1" }
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry


#### update ####
> Update a sensor-gantry with id = <id\>

* URL: /sensor-gantry/<id\>
* Method: PUT
* Data: {  "label": "Test-Gantry",
           "serial": "abcdefgh-12345678",
           "car_park_id": "1" }
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/1


#### delete ####
> Delete a sensor-gantry with id = <id\>

* URL: /sensor-gantry/<id\>
* Method: DELETE
* Access: Manager

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/sensor-gantry/1



## Traffic Flow ##
> Each car-entry or car-exit event is recorded as a traffic-flow.

#### list ####
> List all traffic flows. optional to get related sensor-gantry and car-park

* URL: /sensor-gantry?expand=carPark, gantry
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1//traffic-flow
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1//traffic-flow?expand=carPark,gantry


#### view ####
> View detail info of a traffic flow.

* URL: /traffic-flow/<id\>?expand=gantry,carPark
* Method: GET
* Access: Anonymous

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/100
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/100?expand=carPark,gantry


#### search ####
> Search for traffic flow which fulfils the query condition(s).

* URL: /traffic-flow/search?<query\>
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/search?car_park_id=1


#### Car Entry ####
> create a traffic flow for car-entry event. It will also update the car-count column in car-park table, and entry-count column in sensor-gantry table.

* URL: /traffic-flow/car-entry/<gantry_serial\>
* Method: POST
* Access: User

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/car-entry/6792b9e854279c65e722


#### Car Exit ####
> create a traffic flow for car-entry event. It will also update the car-count column in car-park table, and exit-count column in sensor-gantry table. gantry_serial is a unique ID of a gantry

* URL: /traffic-flow/car-exit/<gantry_serial\>
* Method: POST
* Access: User

Example

* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/car-exit/6792b9e854279c65e722


#### Latest by Car Park ####
> get the latest parking lot information by car-park ID.

* URL: /traffic-flow/latest-by-car-park/<car_park_id\>
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/latest-by-car-park/1


#### Latest All Car Park ####
> get the latest parking lot information of all car-parks.

* URL: /traffic-flow/latest-all-car-park
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/latest-all-car-park


#### Latest All Car Park Today ####
> get the latest parking lot information of all car-parks of today.

* URL: /traffic-flow/latest-all-car-park-today
* Method: GET
* Access: Anonymous

Example: 
    
* http://eceiot.np.edu.sg/parking-lots/api/web/index.php/v1/traffic-flow/latest-all-car-park-today


