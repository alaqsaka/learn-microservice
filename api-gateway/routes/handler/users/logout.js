const apiAdapter = require("../../apiAdapter");
const { URL_SERVICE_USER } = process.env;

const api = apiAdapter(URL_SERVICE_USER);

module.exports = async (req, res) => {
  try {
    const id = req.user.data.id;
    const user = await api.post(`/users/logout`, { user_id: id });
    return res.json(user.data);
  } catch (error) {
    if (error.code === "ECONNREFUSED") {
      return res.status(500).json({
        status: "error",
        message: "Service Unavailable",
      });
    }

    const { status, data } = error.response;
    // console.log(data);
    return res.status(status).json(data);
  }
};
