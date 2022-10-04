const bcrypt = require("bcrypt");
const { User } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const schema = {
    name: "string|empty:false",
    email: "email|empty:false",
    password: "string|min:6",
    profession: "string|optional",
    avatar: "string|optional",
  };

  const validate = v.validate(req.body, schema);

  // kalau ada error
  if (validate.length) {
    return res.status(400).json({
      status: "error",
      message: validate,
    });
  }

  // kalau tidak ada error

  const id = req.params.id;
  const user = await User.findByPk(id);

  // kalau user tidak ada
  if (!user) {
    return res.status(404).json({
      status: "error",
      message: "User not found",
    });
  }

  // kalau user ada
  const email = req.body.email;

  if (email) {
    // mengecek apakah email duplicate?
    const checkEmail = await User.findOne({
      where: {
        email,
      },
    });

    if (checkEmail && email !== user.email) {
      return res.status(409).json({
        status: "error",
        message: "Email already exist",
      });
    }
  }

  const password = await bcrypt.hash(req.body.password, 10);
  const { name, profession, avatar } = req.body;

  await user.update({
    email,
    password,
    name,
    profession,
    avatar,
  });

  return res.status(200).json({
    status: "success",
    data: {
      id: user.id,
      name,
      email,
      profession,
      avatar,
    },
  });
};
