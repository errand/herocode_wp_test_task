/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { SelectControl, TextControl  } from '@wordpress/components';
import { useSelect } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({attributes, setAttributes}) {

	const productsList = useSelect( ( select ) => {
		return select( 'core' ).getEntityRecords( 'postType', 'product', { status : 'publish' } );
	} )

	const updatePriceValue = ( val ) => {
		setAttributes( { price: val } );
	}

	const updateProductValue = ( val ) => {
		setAttributes( { product: val } );
	}


	let options = [];
	if( productsList ) {
		options.push( { value: 0, label: __('Select Product') } )
		productsList.forEach( ( page ) => {
			options.push( { value : page.id, label : page.title.rendered } )
		})
	} else {
		options.push( { value: 0, label: __('Loading...') } )
	}

	return (
		<p { ...useBlockProps() }>
			<SelectControl
				label={__("Select Product")}
				options={ options }
				value={attributes.product}
				onChange={ updateProductValue }
			/>
			<TextControl
				label={__("Price")}
				value={attributes.price}
				onChange={ updatePriceValue }
			/>
		</p>
	);
}
