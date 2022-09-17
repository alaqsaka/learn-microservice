const axios = require("axios");
const { TIMEOUT } = process.env;

module.exports = (baseUrl) => {
  console.log(baseUrl);
  return axios.create({
    baseURL: baseUrl,
    timeout: parseInt(TIMEOUT),
  });
};
