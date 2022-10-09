const { User, RefreshToken } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const userId = req.body.user_id;
  const refreshToken = req.body.refresh_token;

  // menit 6.48
};
