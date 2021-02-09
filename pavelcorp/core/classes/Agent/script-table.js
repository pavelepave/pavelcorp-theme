jQuery(document).ready(function ($) {

  window.addNewHeadCol = addNewHeadCol;
  window.addNewRow = addNewRow;
  window.checkValue = checkValue;
  window.removeRow = removeRow;

  if (typeof tinyMCE === "object" && typeof tinyMCE.init == "function") {
    tinyMCE.init({ selector: '.pvcTinyMCE' });
  }

  /**
   * Remove generated row / cols
   */
  function removeRow(evt) {
    evt.target.parentElement.remove();
  }

  /**
   * Change hidden input value based on sibbling checkbox state
   */
  function checkValue(evt) {
    var checked = evt.target.checked;
    var input = evt.target.previousElementSibling;
    input.value = checked ? 'on' : 'off';
  }

  /**
   * Event handler : add new body row
   */
  function addNewRow(evt) {
    evt.preventDefault();
    var cols = JSON.parse(evt.target.dataset.cols);
    var parent = evt.target.previousElementSibling;

    createNewBodyRow(parent, cols, parent.children.length);
  }

  /**
   * Create new inputs row
   * @param {HTMLElement} el 
   * @param {string[]} rows 
   * @param {number} i Index
   */
  function createNewBodyRow(parent, cols, i) {
    var row = document.createElement('div')
    var name = parent.dataset.name + '[body][' + i + ']';

    cols.forEach(function (type, j) {
      var input = initInput(type, name + '[' + j + ']');
      row.appendChild(input);

      if (type === 'editor') {
        createTinyMCE(input.firstElementChild.id);
      }
    });

    parent.appendChild(row);
  }

  /**
   * Event handler : add new head inputs row
   */
  function addNewHeadCol(evt) {
    evt.preventDefault();
    var rows = JSON.parse(evt.target.dataset.rows);
    var parent = evt.target.previousElementSibling;

    createNewHeadCol(parent, rows, parent.children.length);
  }

  /**
   * Create new inputs column
   * @param {HTMLElement} el 
   * @param {string[]} rows 
   * @param {number} i Index
   */
  function createNewHeadCol(parent, rows, i) {
    var row = document.createElement('div')
    var name = parent.dataset.name + '[head][' + i + ']';

    rows.forEach(function (type, j) {
      var input = initInput(type, name + '[' + j + ']');
      row.appendChild(input);

      if (type === 'editor') {
        createTinyMCE(input.firstElementChild.id);
      }
    });

    parent.appendChild(row);
  }

  /**
   * Generate input based on type
   * @param {string} type Input type : text, textarea, checkbox
   * @return {HTMLElement} Input
   */
  function initInput(type, name) {
    var input = document.createElement('div');

    switch (type) {
      case 'editor':
        var textarea = document.createElement('textarea');
        textarea.name = name;
        textarea.id = Math.random().toString(36).substr(2);
        input.appendChild(textarea);
        break;
      case 'checkbox':
        var label = document.createElement('label');
        var checkbox = document.createElement('input');
        var hidden = document.createElement('input');
        var span = document.createElement('span');
        var id = Math.random().toString(36).substr(2);;

        label.classList = 'TableCheckbox';
        label.for = id;

        hidden.type = 'hidden';
        hidden.name = name;
        hidden.value = 'off';

        checkbox.id = id;
        checkbox.name = '_' + name;
        checkbox.type = type;
        checkbox.onclick = checkValue;


        label.appendChild(hidden);
        label.appendChild(checkbox);
        label.appendChild(span);
        input.appendChild(label);
        break;
      case 'text':
      default:
        var text = document.createElement('input');
        text.type = type;
        text.name = name;
        input.appendChild(text);
        break;
    }
    return input;
  }



  /**
   * Generate new TinyMCE input
   * @param {string} id Textarea id
   */
  function createTinyMCE(id) {
    if (typeof tinyMCE === "object" && typeof tinyMCE.init == "function") {
      var interval = setInterval(function () {
        if (document.getElementById(id)) {
          tinyMCE.init({ selector: "#" + id });
          clearInterval(interval);
        }
      }, 200);
    }
  }


});
