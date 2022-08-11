import SourceEditing from "@ckeditor/ckeditor5-source-editing/src/sourceediting";
import Markdown from "@ckeditor/ckeditor5-markdown-gfm/src/markdown";

ClassicEditor.create(document.querySelector("#editor"), {
  plugins: [SourceEditing, Markdown],
  toolbar: {
    items: [
      "heading",
      "|",
      "fontfamily",
      "fontsize",
      "|",
      "alignment",
      "|",
      "fontColor",
      "fontBackgroundColor",
      "|",
      "bold",
      "italic",
      "strikethrough",
      "underline",
      "subscript",
      "superscript",
      "|",
      "link",
      "|",
      "outdent",
      "indent",
      "|",
      "bulletedList",
      "numberedList",
      "todoList",
      "|",
      "code",
      "codeBlock",
      "|",
      "insertTable",
      "|",
      "uploadImage",
      "blockQuote",
      "|",
      "undo",
      "redo",
    ],
  },
  shouldNotGroupWhenFull: true,
}).catch((error) => {
  console.log(error);
});
