"use strict";

var _sourceediting = _interopRequireDefault(require("@ckeditor/ckeditor5-source-editing/src/sourceediting"));

var _markdown = _interopRequireDefault(require("@ckeditor/ckeditor5-markdown-gfm/src/markdown"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

ClassicEditor.create(document.querySelector("#editor"), {
  plugins: [_sourceediting["default"], _markdown["default"]],
  toolbar: {
    items: ["heading", "|", "fontfamily", "fontsize", "|", "alignment", "|", "fontColor", "fontBackgroundColor", "|", "bold", "italic", "strikethrough", "underline", "subscript", "superscript", "|", "link", "|", "outdent", "indent", "|", "bulletedList", "numberedList", "todoList", "|", "code", "codeBlock", "|", "insertTable", "|", "uploadImage", "blockQuote", "|", "undo", "redo"]
  },
  shouldNotGroupWhenFull: true
})["catch"](function (error) {
  console.log(error);
});