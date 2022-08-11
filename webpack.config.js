const path = require("path");

module.exports = {
  entry: "./src/ckeditor.js",
  output: {
    filename: "ckeditor.js",
    path: path.resolve(__dirname, "dist"),
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: ["style-loader", "css-loader"],
      },
    ],
  },
};
