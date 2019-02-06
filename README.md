# phporm
A php library to map database tables to php objects and perform crud operations via model instance 

Edit the config.php and put your custom MySQL configurations

Create a model class that extends DBObject

I have not yet included namespaces but will soon

Declare fields that are public.Field must be public for mapper to access it

By default the table the model is related to is the class name but to change 
add public variable $table to override the default name 

