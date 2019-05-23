# phporm
A php library to map database tables to php objects and perform crud operations via model instance.

Much like <b>Laravel</b> or <b>Slim</b> but i feel its more <b><i>friendly, editable</i></b> & <b><i>lighter</i></b> especially for building backend apis for different services e.g android as the main intention for collecting the codes to the orm scripts collection , codes in the file are a collection of codes form different sources and some are my own work. 

<b>1.</b> You can study the DBObject.php to understand the core working of the Mapper

<b>2.</b> sessions.php is used for managing sessions if your building a web application using php.

<b>3.</b> Edit the config.php and put your custom MySQL configurations

Create a model class that extends <b>DBObject</b>
e.g <code>class Doctor extends DBObject{</code>

I have not yet included namespaces but will soon

Object </b>properties</b> are declared <b>public</b> field must be public for mapper to access it

By default the <b>table</b> the model is related to is the <b>class name</b> but to change 
add <b>protected $table</b> to override the default name 

The foreign key is derived from the Model Class name e.g for class Doctor that extends DBObject it becomes doctor_id
but you can override it by declaring <code>protected $foreign_key_name = ''</code>
