jQuery(document).ready(function ($) {

	window.handleMedia = handleMedia;
	window.checkValue = checkValue;

	// Instantiates the variable that holds the media library frame.
	var meta_image_frame;

	$('.single-preview > div > .remove,.gallery-preview > div > .remove')
		.on('click', removeFromGallery)

	// Runs when the image button is clicked.
	$('.single-upload, .gallery-upload').on('click', handleMedia);

	// Init tinyMCE 
	if (typeof tinyMCE === "object" && typeof tinyMCE.init == "function") {
		tinyMCE.init({ selector: '.pvcTinyMCE' });
	}

	$('.TableContainer').each(function () {
		var table = new Table(this);

		/**
		 * Remove generated row / cols
		 */
		function removeRow(evt) {
			evt.target.parentElement.remove();
		}

		$('.AddHeadRow', this).on('click', function (evt) {
			evt.preventDefault();
			var length = table.head.children.length;
			table.createNewHeadCol(length);
		})

		$('.AddBodyRow', this).on('click', function (evt) {
			evt.preventDefault();
			var length = table.body.children.length;
			table.createNewBodyRow(length);
		})

		$('.RemoveRow', this).on('click', removeRow);
	});

	$('.GroupContainer').each(function () {
		var inputs = new CustomInputs(this.querySelector('.MetaGroups'));

		/**
		 * Event handler : add new body row
		 */
		$('.AddCustomRow', this).on('click', function (evt) {
			evt.preventDefault();
			var length = inputs.container.children.length;
			inputs.createNewRow(length);
		});

		$('.RemoveRow', this).on('click', function (evt) {
			inputs.removeRow(evt);
		});
	});


	/**
	 * Custom inputs
	 */
	function CustomInputs(container) {
		this.container = container;
		this.name = container.dataset.name;
		this.shape = JSON.parse(container.dataset.shape);
	}

	/**
	 * Create new inputs row
	 * @param {HTMLElement} parent 
	 * @param {string[]} shape 
	 * @param {number} i Size
	 */
	CustomInputs.prototype.createNewRow = function (length) {
		var row = document.createElement('div')
		var name = this.name + '[' + length + ']';
		var remove = createRemove(this.removeRow);

		row.classList = 'MetaGroup';
		row.appendChild(remove);

		for (var key in this.shape) {
			var type = this.shape[key];
			var input = initInput(type, name + '[' + key + ']');
			row.appendChild(input);

			if (type === 'editor') {
				createTinyMCE(input.firstElementChild.id);
			}
		}
		this.container.appendChild(row);
	}

	/**
	 * Remove inputs row
	 */
	CustomInputs.prototype.removeRow = function (evt) {
		var row = evt.target.parentElement;
		row.remove();

		for (let i = 0; i < this.container.children.length; i++) {
			changeInputsName(this.container.children[i], i);
		}
	}


	/**
	 * Checkbox
	 * @param {HTMLElement} input
	 */
	function InputCheckbox(input) {
		this.input = input;
	}
	/**
	 * Check / Uncheck value
	 * @param {Boolean checked 
	 */
	InputCheckbox.prototype.checkValue = function (checked) {
		this.input.previousElementSibling.value = checked ? 'on' : 'off';
	}
	function checkValue(evt) {
		var checkbox = new InputCheckbox(evt.target);
		checkbox.checkValue(evt.target.checked);
	}

	/**
	 * Table row
	 */
	function Table(container) {
		this.container = container;
		this.head = container.querySelector('.TableHead');
		this.body = container.querySelector('.TableBody');

		this.name = container.dataset.name
		this.cols = JSON.parse(container.dataset.cols);
		this.rows = JSON.parse(container.dataset.rows);
	}

	/**
	 * Create new inputs row
	 * @param {HTMLElement} el 
	 * @param {string[]} rows 
	 * @param {number} i Index
	 */
	Table.prototype.createNewBodyRow = function (i) {
		var row = document.createElement('div')
		var name = this.name + '[body][' + i + ']';

		this.cols.forEach(function (type, j) {
			var input = initInput(type, name + '[' + j + ']');
			row.appendChild(input);

			if (type === 'editor') {
				createTinyMCE(input.firstElementChild.id);
			}
		});

		this.body.appendChild(row);
	}


	/**
	 * Create new inputs column
	 * @param {HTMLElement} el 
	 * @param {string[]} rows 
	 * @param {number} i Index
	 */
	Table.prototype.createNewHeadCol = function (i) {
		var row = document.createElement('div')
		var name = this.name + '[head][' + i + ']';

		this.rows.forEach(function (type, j) {
			var input = initInput(type, name + '[' + j + ']');
			row.appendChild(input);

			if (type === 'editor') {
				createTinyMCE(input.firstElementChild.id);
			}
		});

		this.body.appendChild(row);
	}

	/**
	 * Generate input based on type
	 * @param {string} type Input type : text, textarea, checkbox
	 * @return {HTMLElement} Input
	 */
	function initInput(type, name) {
		var input = document.createElement('div');

		switch (type) {
			case 'image':
				var container = document.createElement('div');
				container.classList = 'single-preview preview-zone';
				container.dataset.info = JSON.stringify({ name: name });

				var button = document.createElement('input');
				button.type = 'button';
				button.classList = 'button single-upload';
				button.value = 'Select image';
				button.onclick = window.handleMedia;

				input.appendChild(container);
				input.appendChild(button);
				break;
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

	/**
	 * Change input name according to place in queue
	 * @param {HTMLElement} element 
	 */
	function changeInputsName(element, index) {
		var inputs = element.querySelectorAll('[name]');

		for (let i = 0; i < inputs.length; i++) {
			var name = inputs[i].name.replace(/[0-9]+/g, index);
			inputs[i].name = name;
		}
	}

	/**
	 * Create remove button
	 */
	function createRemove(fn) {
		var a = document.createElement('a');
		a.classList = 'RemoveRow';
		a.href = 'javascript:{}';
		a.onclick = fn;
		a.innerText = '[ remove ]';

		return a;
	}

	/**
	 * Remove image from gallery
	 * @param {Boolean} isSingle 
	 */
	function removeFromGallery() {

		var gallery = $(this).parent().parent();
		// Remove img
		$(this).parent().remove();

		var children = gallery.children();
		// Rename all sibblings
		var name = JSON.parse(gallery.attr('data-info')).name;

		// Rename
		if (children.length > 0) {
			children.each(function (index) {
				var container = $(this);
				var input = container.children('input');
				input.attr('name', name + '[' + index + ']')
			})
		}
	}

	/**
	 * Open media upload and handle selection
	 */
	function handleMedia(evt) {
		evt.preventDefault();
		var meta_image_preview = $(this).parent().children('.preview-zone ');
		var name = JSON.parse(meta_image_preview.attr('data-info')).name;

		meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
			title: '',
			button: {
				stext: ''
			}
		});

		meta_image_frame.on('select', function () {
			handleSelectMedia(name, meta_image_preview);
		});

		// Opens the media library frame.
		meta_image_frame.open();

	}

	/**
	 * Handle media selection
	 * @param {string} name boo
	 * @param {boolean} isSingle 
	 */
	function handleSelectMedia(name, meta_image_preview) {
		// Grabs the attachment selection and creates a JSON representation of the model.
		var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
		// Sends the attachment URL to our custom image input field.
		var id, url, size;
		id = media_attachment.id;
		url = media_attachment.url;
		size = meta_image_preview.children().length;

		var isSingle = meta_image_preview.hasClass('single-preview');
		var isVideo = videoCheck(url);

		var imgName = isSingle ? name : name + '[' + size + ']';
		var imageTag = isVideo && isSingle ? 'video' : 'img';

		// Remove btn
		var a = createRemoveButton();
		var img = createImg(imageTag, url);
		var input = createImgInput(id, imgName);

		var container = document.createElement('div');
		container.appendChild(a);
		container.appendChild(input);
		container.appendChild(img);

		if (isSingle) {
			// Remove current img
			meta_image_preview.children().remove();
		}

		meta_image_preview.append(container);

	}

	/**
	 * Create image tag
	 * @param {string} tag 
	 * @param {string} url 
	 */
	function createImg(tag, url) {
		var img = document.createElement(tag);
		img.src = url;

		return img;
	}

	/**
	 * Create button to remove img
	 */
	function createRemoveButton() {
		var a = document.createElement('a');
		a.innerText = 'X';
		a.classList.add('remove');
		a.addEventListener('click', removeFromGallery);

		return a;
	}

	/**
	 * Create hidden input holding img id
	 */
	function createImgInput(id, name) {
		var input = document.createElement('input');
		input.type = "hidden";
		input.value = id;
		input.name = name;

		return input;
	}

	/**
	 * Check if media is a video 
	 * @param {string} url 
	 */
	function videoCheck(url) {
		var arrUrl = url.split('.');
		var ext = arrUrl[arrUrl.length - 1].toLowerCase();

		return ext === "mp4" || ext === "webm" || ext === "ogg";
	}

});
