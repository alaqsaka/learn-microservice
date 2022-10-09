const { RefreshToken } = require("../../../models");

module.exports = async (req, res) => {
  const refreshToken = req.query.refresh_token;

  // check if refresh token available in database
  const token = await RefreshToken.findOne({
    where: {
      token: refreshToken,
    },
  });

  // if token not exist in db
  if (!token) {
    return res.status(400).json({
      status: "error",
      message: "Invalid Token",
    });
  }

  // if token exist in db
  return res.json({
    status: "success",
    token,
  });
};
