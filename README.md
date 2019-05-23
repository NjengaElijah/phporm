# phporm
A php library to map database tables to php objects and perform crud operations via model instance.

Much like <b>Laravel</b> or <b>Slim</b> but i feel its more <b><i>friendly, editable & lighter</i></b> especially for building apis for different services especially android as it was my mainintention for collecting the codes in the library , codes in the file are a collection of codes form different sources and some are my own work. 

You can study the DBObject.php to understand the core working of the Mapper

Edit the config.php and put your custom MySQL configurations

Create a model class that extends <b>DBObject</b>
e.g <code>class Doctor extends DBObject{</code>

I have not yet included namespaces but will soon

Object </b>properties</b> are declared <b>public</b> field must be public for mapper to access it

By default the <b>table</b> the model is related to is the <b>class name</b> but to change 
add <b>protected $table</b> to override the default name 

The foreign key is derived from the Model Class name e.g for class Doctor that extends DBObject it becomes doctor_id
but you can override it by declaring <code>protected $foreign_key_name = ''</code>
