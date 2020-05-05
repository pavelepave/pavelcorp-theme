import React, { useState, useEffect, useRef } from 'react'

const input = React.createRef();

/**
 * Custom select input
 * goes with custom-select.scss
 * @param {Object[]} 	options.options 			Label / Value list
 * @param {string} 		options.className 		Custom css class
 * @param {string} 		options.name 					Input name
 * @param {string} 		options.id 						Input id
 * @param {string} 		options.defaultValue 	Input initial value
 * @param {function} 	options.onChange 			onchange event handler
 */
export default function OptionSelector({
	options, 
	className, 
	name, 
	id, 
	defaultValue,
	onChange
}) {
	const isFirstRun = useRef(true);
 
	const [height, setHeight] = useState(0);
	const [selectedValue, setValue] = useState(options.find(({value}) => {
		return value.toString() === defaultValue.toString()
	}) || options[0]);


	useEffect(() => {
		let newValue = options.find(({value}) => {
			return value.toString() === defaultValue.toString()
		});
		
		if ( newValue && newValue.value != selectedValue.value ) {
			setValue(newValue);
		}
	}, [options.length]);

	/**
	 * Simulate onchange event
	 * @param  {[type]} ( [description]
	 * @return {[type]}   [description]
	 */
	useEffect(() => {
		if (isFirstRun.current) {
      isFirstRun.current = false;
      return;
    }

		onChange({target: { 
			value: selectedValue.value,
			form: input.current.form,
			name
		}});
	}, [selectedValue.value])

	/**
	 * Update selected value
	 * @param  {[type]} value [description]
	 * @return {[type]}       [description]
	 */
	const updateValue = function(option) {
		return (evt) => {
			evt.preventDefault();
			setValue(option);
		}
	}

	/**
	 * Toggle options
	 * @param  {[type]} evt [description]
	 * @return {[type]}     [description]
	 */
	function updateHeight(evt) {
		const { currentTarget } = evt;
		const { length } = options;
		
		if ( height === 0)
			setHeight( currentTarget.offsetHeight * length );
		else
			setHeight(0);
	}

	let aClass = className + ' custom-select';

	if ( height > 0 ) aClass += ' custom-select--open';


	return (
		<div className = { aClass } onClick = { updateHeight }>
			<div 
				className = 'custom-select__input'>
				<input 
					ref = { input }
					id = { id }
					name = { name }
					value = { selectedValue.value }
					type = 'hidden' />

					<span>{ selectedValue.label }</span>

					<div 
						style = {{ maxHeight: height }}
						className = 'custom-select__options'>
						{options.map((option) => {
							const onClick = updateValue(option);
							return (
								<span 
									className = { 
										option.value == selectedValue.value ?  
										'custom-select__selected' : ''
									}
									key = { option.value }
									onClick = { onClick }>{ option.label }</span>
							)
						})}
					</div>
			</div>
		</div>
	)
}

OptionSelector.defaultProps = {
	defaultValue: '',
	className: '',
	name: '',
	id: '',
	onChange: console.log,
	options: []
};

/**
 * Custom select input
 * goes with custom-select.scss
 * @param {Object[]} 	options.options 			Label / Value list
 * @param {string} 		options.className 		Custom css class
 * @param {string} 		options.name 					Input name
 * @param {string} 		options.id 						Input id
 * @param {string} 		options.defaultValue 	Input initial value
 * @param {function} 	options.onChange 			onchange event handler
 */
export function OptionSelectorNoUpdate({
	options, 
	className, 
	name, 
	id, 
	defaultValue,
	onChange
}) {

	const [height, setHeight] = useState(0);
	const [selectedValue, setValue] = useState(options.find(({value}) => {
		return value === defaultValue
	}));

	useEffect(() => {
		if (selectedValue.value == '') return;
		onChange({target: { 
			value: selectedValue.value,
			form: input.current.form,
			name
		}});

		// Back to first option
		setValue(options[0]);
	}, [selectedValue.value])

	/**
	 * Update selected value
	 * @param  {[type]} value [description]
	 * @return {[type]}       [description]
	 */
	const updateValue = function(option) {
		return (evt) => {
			evt.preventDefault();
			setValue(option);
		}
	}

	/**
	 * Toggle options
	 * @param  {[type]} evt [description]
	 * @return {[type]}     [description]
	 */
	function updateHeight(evt) {
		const { currentTarget } = evt;
		const { length } = options;
		
		if ( height === 0)
			setHeight( currentTarget.offsetHeight * length );
		else
			setHeight(0);
	}

	let aClass = className + ' custom-select';

	if ( height > 0 ) aClass += ' custom-select--open';


	return (
		<div className = { aClass } onClick = { updateHeight }>
			<div 
				className = 'custom-select__input'>
				<input 
					ref = { input }
					id = { id }
					name = { name }
					value = { selectedValue.value }
					type = 'hidden' />

					<span>{ selectedValue.label }</span>

					<div 
						style = {{ maxHeight: height }}
						className = 'custom-select__options'>
						{options.map((option) => {
							const onClick = updateValue(option);
							return (
								<span 
									key = { option.value }
									onClick = { onClick }>{ option.label }</span>
							)
						})}
					</div>
			</div>
		</div>
	)
}

OptionSelector.defaultProps = {
	defaultValue: '',
	className: '',
	name: '',
	id: '',
	onChange: console.log,
	options: []
};