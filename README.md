# learn-microservice

### Run seed script by run this command on terminal
Make sure you have `seeders` folder

If you don't have `seeders` folder you can create it by run this command 
Example, create seeders for user table on service-user:

`npx sequelize seed:create --name=user-seeders`

`npx sequelize db:seed:all`

Undo seed script (this will cause your table to be empty)
`npx sequelize db:seed:undo:all`