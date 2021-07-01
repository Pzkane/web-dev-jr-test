/* eslint-disable */
const path = require("path");
module.exports = {
  chainWebpack: (config) => {
    config.resolve.alias
      .set("@", path.resolve(__dirname, "src/"))
      .set("@assets", path.resolve(__dirname, "src/assets/"))
      .set("@components", path.resolve(__dirname, "src/components/"))
      .set("@templates", path.resolve(__dirname, "src/components/templates/"));
  },
};
