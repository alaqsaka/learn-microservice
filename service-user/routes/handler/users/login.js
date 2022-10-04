const bcrypt = require("bcrypt");
const { User } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const schema = {
    email: "email|empty:false",
    password: "string|min:6",
  };

  const validate = v.validate(req.body, schema);
  if (validate.length) {
    return res.status(400).json({
      status: "error",
      message: validate,
    });
  }

  // mengecek apakah email ada di database
  const user = await User.findOne({
    where: { email: req.body.email },
  });

  // jika email ga ada di database
  if (!user) {
    return res.status(404).json({
      status: "error",
      message: "Account with this email not found",
    });
  }

  // jika email ada di db
  // cek apakah passwordnya valid
  const isValidPassword = await bcrypt.compare(
    req.body.password,
    user.password
  );

  if (!isValidPassword) {
    return res.status(404).json({
      status: "error",
      message: "Incorrect password",
    });
  }

  // jika password benar
  res.status(200).json({
    status: "success",
    data: {
      id: user.id,
      name: user.name,
      email: user.email,
      role: user.role,
      avatar: user.avatar,
      profession: user.profession,
    },
  });
};
