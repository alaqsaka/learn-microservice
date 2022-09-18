'use strict';
const bcrypt = require('bcrypt')

module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert('users', [
      {
        name: 'Scott',
        profession: "Admin Micro",
        role: 'admin',
        email: 'scott@admin.com',
        password: await bcrypt.hash('password', 10),
        created_at: new Date(),
        updated_at: new Date()
      },
      {
        name: 'Marco',
        profession: "Software Engineer",
        role: 'student',
        email: 'marco@gmail.com',
        password: await bcrypt.hash('password', 10),
        created_at: new Date(),
        updated_at: new Date()
      }], {});
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('users', null, {});
  }
};
