
# Learn Microservice



## Tech Stack

- Node v14.17.0
- Express
- Composer version 2.3.5
- Laravel 9
- MySQL




## Installation

Directories using NodeJS, Express:
- api-gateway
- service-media
- service-user

Make sure each directory has .env file. 

Example: 
```bash
  // clone this repository
  cd api-gateway 
  npm install 
  cd ..
  cd service-media
  npm install 
  cd ..
  cd service-user
  npm install

  // use npm run start to start every server in each directory
  npm run start 
```
    
Directories using Laravel:
- service-course
## Seeding

### Run seed script by run this command on terminal
Make sure you have `seeders` folder

If you don't have `seeders` folder you can create it by run this command 
Example, create seeders for user table on service-user:

`npx sequelize seed:create --name=user-seeders`

`npx sequelize db:seed:all`

Undo seed script (this will cause your table to be empty)
`npx sequelize db:seed:undo:all`


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

.env for:
- api-gateway
- service-media
- service-user

`PORT`

`DB_NAME`

`DB_USERNAME`

`DB_PASSWORD`

`DB_HOSTNAME`

## API Documentation
[Documentation](https://documenter.getpostman.com/view/14575742/VVBUz73K)
