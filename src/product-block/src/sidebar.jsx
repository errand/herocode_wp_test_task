import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { TextControl  } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';

const CustomTextControl = compose(
	withDispatch( function( dispatch, props ) {
		return {
			setMetaValue: function( value ) {
				dispatch( 'core/editor' ).editPost( { meta: { [props.metaKey]: value } } );
			}
		}
	} ),
	withSelect( function( select, props ) {
		return {
			metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ props.metaKey ],
		}
	} )
)( function( props ) {

	return (
		<TextControl
			type="number"
			label={ props.label }
			value={ props.metaValue }
			onChange={ ( content ) => { props.setMetaValue( content ) } }
		/>
	);
} );

export default function Sidebar(){
	return (
		<>
			<PluginDocumentSettingPanel
				name="product-panel"
				label=""
				title="Price"
				className="product-panel"
			>
				<CustomTextControl metaKey="product_price" required />
			</PluginDocumentSettingPanel>
		</>
	)
}
