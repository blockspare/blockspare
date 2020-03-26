import classnames from 'classnames';
import Inspector from './components/inspector';
import paddingMargin from '../../utils/styles/margin-padding';
import boxShadowStyles from "../../utils/styles/box-shadow";
import iconColorOptions from "../../utils/styles/icon-color"
const prev_img = blockspare_globals;

const ALLOWED_BLOCKS = [ 'core/image'];
const TEMPLATE = [
    ['core/image',{
        url:prev_img.menu_img_url,
        className:'is-style-circle-mask',
        width:120,
        height:120,
        align:'center',

    }]
];

const {__} = wp.i18n;

const {Component, Fragment} = wp.element;

const {
    RichText,
    InnerBlocks
} = wp.blockEditor;



/**
 * Block edit function
 */
export default class Edit extends Component {
    render() {

        const {
            attributes: {
                price,
                priceTitle,
                priceDescription,
                priceUnit,
                layoutOptions,
                priceUnitPosition,
                showDots,
                priceTitleColor,
                priceColor,
                priceUnitColor,
                priceDescriptionColor,
                backgroundColor,
                showImage,
                imgIconOption,
                name,
                iconSize,
                iconStyles,
                blockBorderRadius
            },
            attributes,
            setAttributes

        } = this.props;

        const iconStylescss ={

           ...iconColorOptions(attributes)
        };

        return (

            <Fragment>
                <Inspector  {...this.props}/>

                <div className={classnames(
                    'blockspare-price-list-wrap',
                    layoutOptions,
                    priceUnitPosition
                )}
                style={{
                    ...paddingMargin(attributes),
                    ...boxShadowStyles(attributes),
                    backgroundColor: backgroundColor?backgroundColor:"#fff",
                    borderRadius: blockBorderRadius ? blockBorderRadius : null,
                }}
                >

                    <div className={`blockspare-img-wrapper`}>

                    {showImage && imgIconOption =='image' &&
                    <InnerBlocks
                        template={ TEMPLATE }
                        allowedBlocks={ ALLOWED_BLOCKS }
                        templateLock={ true }
                        templateInsertUpdatesSelection={ true }
                    />
                    }
                    </div>
                    {showImage && imgIconOption =='icon' &&
                    <div className='blockspare-block-icon-wrapper'>
                        <div className={classnames(
                            'blockspare-block-icon',
                            iconSize,
                            iconStyles)}
                             style={iconStylescss}>
                            <i className={name}/>
                        </div>
                    </div>
                    }
                    <div className="blockspare-price-content">
                        <div className="blockspare-price-header">

                            <RichText
                                tagName="h4"
                                className="blockspare-title"
                                onChange={(value) => setAttributes({priceTitle: value})}
                                value={priceTitle}
                                style={{
                                    color:priceTitleColor?priceTitleColor:"#404040"
                                }}
                                placeholder={__('Title', 'blockspare')}
                                keepPlaceholderOnFocus
                            />
                            {showDots &&
                                <span className='blockspare-price-divider' style={{
                                    color:priceDescriptionColor?priceDescriptionColor:'#6d6d6d'
                                }}></span>
                            }
                            <div className="blockspare-price-unit-wrap">
                                <RichText
                                    tagName="span"
                                    className="blockspare-price"
                                    onChange={(value) => setAttributes({price: value})}
                                    value={price}
                                    style={{
                                        color:priceColor?priceColor:"#af0000"
                                    }}
                                    placeholder={__('Price', 'blockspare')}
                                    keepPlaceholderOnFocus
                                />

                                <RichText
                                    tagName="span"
                                    className="blockspare-unit"
                                    onChange={(value) => setAttributes({priceUnit: value})}
                                    value={priceUnit}
                                    style={{
                                        color:priceUnitColor?priceUnitColor:"#af0000"
                                    }}
                                    placeholder={__('$', 'blockspare')}
                                    keepPlaceholderOnFocus
                                />
                            </div>
                        </div>
                        <RichText
                            tagName="p"
                            className="blockspare-description"
                            onChange={(value) => setAttributes({priceDescription: value})}
                            value={priceDescription}
                            placeholder={__('Description', 'blockspare')}
                            style={{
                                color:priceDescriptionColor?priceDescriptionColor:"#6d6d6d"
                            }}
                            keepPlaceholderOnFocus
                        />
                    </div>
                </div>
            </Fragment>
        );
    }
}