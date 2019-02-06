# phporm
A php library to map database tables to php objects and perform crud operations via model instance 

Edit the config.php and put your custom MySQL configurations

Create a model class that extends <b>DBObject</b>

I have not yet included namespaces but will soon

Object </b>properties</b> are declared <b>public</b>.Field must be public for mapper to access it

By default the <b>table</b> the model is related to is the <b>class name</b> but to change 
add public variable <b>protected $table</b> to override the default name 

