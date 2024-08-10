const { getConfig } = require("@craftcms/webpack");

module.exports = getConfig({
  context: __dirname,
  config: {
    entry: {
      AssetIndex: "./AssetIndex.js",
    },
  },
});
