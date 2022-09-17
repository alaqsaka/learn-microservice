const express = require("express");
const router = express.Router();
const isBase64 = require("is-base64");
const base64Img = require("base64-img");
const { Media } = require("../models");
const fs = require("fs");

router.get("/", async (req, res) => {
  const media = await Media.findAll({
    attributes: ["id", "image"],
  });

  const mappedMedia = media.map((m) => {
    m.image = `${req.get("host")}/${m.image}`;

    return m;
  });

  return res.json({
    status: "success",
    data: mappedMedia,
  });
});

router.post("/", (req, res) => {
  console.log("post");
  const image = req.body.image;

  // cek apakah image merupakan base64 atau bukan
  if (!isBase64(image, { mimeRequired: true })) {
    return res.status(400).json({
      status: "error",
      message: "Invalid base64",
    });
  }

  base64Img.img(image, "./public/images", Date.now(), async (err, filepath) => {
    if (err) {
      return res.status(400).json({
        status: "error",
        message: err.message,
      });
    }

    const filename = filepath.split("\\").pop().split("/").pop();
    const media = await Media.create({ image: `images/${filename}` });
    return res.json({
      status: "success",
      data: {
        id: media.id,
        image: `${req.get("host")}/images/${filename}`,
      },
    });
  });
});

router.delete("/:id", async (req, res) => {
  const id = req.params.id;

  // mengeceka apakah id ada di table
  const media = await Media.findByPk(id);

  // jika media tidak ada
  if (!media) {
    return res.status(404).json({
      status: "error",
      message: "Media not found",
    });
  }

  // jika media ada
  fs.unlink(`./public/${media.image}`, async (err) => {
    if (err) {
      return res.status(400).json({
        status: "error",
        message: err.message,
      });
    }

    await media.destroy();
    return res.status(200).json({
      status: 200,
      success: true,
      message: "Media successfully deleted",
    });
  });
});

module.exports = router;
