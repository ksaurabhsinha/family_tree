# WorkBox
Simple PHP7 Docker &amp; Compose Environment

## Technology included

* [Nginx](http://nginx.org/)
* [MySQL](http://www.mysql.com/)
* [PHP 7](http://php.net/)

## Requirements

* [Docker Native](https://www.docker.com/products/overview)

## Running

 - Clone the repository.
 - Change directory into the cloned project.
 - Use the following command.
 
### Configuration File
```sh
$ cp .env.example .env
```

### First Time Setup
```sh
$ make install
```

### Setup only the project
```sh
$ make setup
```

### Stop the project and remove containers
```sh
$ make remove_containers
```

### Stop the project and remove virtual machine
```sh
$ make destroy_machine
```

### List of all supported commands
```sh
    make install                 -> creates the machine and then does the setup
    make setup                   -> runs the projects setup (machine should already be available)
    make remove_containers       -> removes all the containers
    make destroy_machine         -> destroys the machine (everything will be gone :) )
    make project_config          -> shows the project configuration details
    make project_deps            -> fulfils the project dependancies (composer...)
```
