const apiAdapter = require("../../apiAdapter");
const { URL_SERVICE_MEDIA } = process.env;

const api = apiAdapter(URL_SERVICE_MEDIA);

module.exports = async (req, res) => {
  try {
    console.log("Try");
    // console.log(req.body);
    const media = await api.post("/media", req.body);
    return res.send(media.data);
  } catch (error) {
    if(error.code === "ECONNREFUSED") {
      return res.status(500).json({
        status: 'error',
        message: 'Service Unavailable'
      })
    }

    const { status, data } = error.response;
    // console.log(data);
    return res.status(status).json(data);
  }
};
