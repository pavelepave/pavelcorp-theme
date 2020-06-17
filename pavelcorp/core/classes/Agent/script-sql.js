jQuery(document).ready(function ($) {

  window.addNewSelector = addNewSelector;

  function addNewSelector(evt) {
    evt.preventDefault();
    var button = evt.currentTarget;
    var name = button.dataset.name;
    var options = JSON.parse(button.dataset.options).map(function (option) {
      return {
        label: option.post_title,
        value: option.ID,
      };
    });
    var selector = createSelector(name, options)
    
    button.parentElement.insertBefore(selector,button);
  }
  
  /**
   * Create an option HTMLElement
   * @param {string} value 
   * @param {string} label 
   * @returns {HTMLElement}
   */
  function createOption(value,label) {
    var option = document.createElement('option');
    option.value = value;
    option.innerText = label;
    return option;
  }

  /**
   * Create an select HTMLElement
   * @param {string} name
   * @returns {HTMLElement}
   */
  function createSelect(name) {
    var select = document.createElement('select');
    select.name = name;
    return select;
  }

  /**
   * Create an select HTMLElement with options
   * @param {string} name 
   * @param {array} options 
   * @returns {HTMLElement}
   */
  function createSelector(name, options) {
    var select = createSelect(name + '[]');
    // Default unselected
    var defaultOption = createOption('', '---');
    defaultOption.selected = true;
    select.appendChild(defaultOption);

    // Other options
    for (var i = 0; i < options.length; i++) {
      var option = createOption(options[i].value, options[i].label);
      select.appendChild(option);
    }

    return select;
  }

});
