# Locations

| Route                                     | HTTP Verb	 | POST body	 | Description	 |
|-------------------------------------------| --- | --- | --- |
| /api/location/create                      | `POST` | {'latitude':40.19407, 'longitude':29.055530, 'name':'test', 'color':'#FFFFFF' } | Create a new location.  |
| /api/location/update/:location_id         | `POST` | {'latitude':40.19407, 'longitude':29.055530, 'name':'test', 'color':'#FFFFFF' } | Update a location. |
| /api/location                             | `GET` | Empty | List all locations. |
| /api/location/select/:location_id         | `GET` | Empty | Select location. |

# Route

| Route | HTTP Verb	 | POST body	 | Description	 |
| --- | --- | --- | --- |
| /api/route | `POST` | { 'latitude': 38.29425, 'longitude':27.14929 | Create route. |
