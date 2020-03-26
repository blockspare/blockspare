import paddingMargin from '../../utils/styles/margin-padding';
import classnames from 'classnames';
import boxShadowStyles from "../../utils/styles/box-shadow";
import iconColorOptions from "../../utils/styles/icon-color";
const {
    InnerBlocks,
    RichText
} = wp.blockEditor;
const { Component } = wp.element;
 export default class Save extends Component{
     constructor() {
         super(...arguments);
     }
    render() {
        const {
          attributes:{
              priceTitle,
              priceDescription,
              priceUnit,
              price,
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
          attributes


        } = this.props;


        const iconStylescss ={
            ...iconColorOptions(attributes)
        };



        return (
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
                <div className={`blockspare-imge-wrapper`}>
                {showImage && imgIconOption =='image' &&
                <InnerBlocks.Content />
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

                        <RichText.Content
                            tagName="h4"
                            className="blockspare-title"
                            value={priceTitle}
                            style={{
                                color:priceTitleColor?priceTitleColor:"#404040"
                            }}
                        />
                        {showDots &&
                        <span className='blockspare-price-divider' style={{
                            color:priceDescriptionColor?priceDescriptionColor:'#6d6d6d'
                        }}></span>
                        }

                        <div className="blockspare-price-unit-wrap">
                            <RichText.Content
                                tagName="span"
                                className="blockspare-price"
                                value={price}
                                style={{
                                    color:priceColor?priceColor:"#af0000"
                                }}
                            />
                            <RichText.Content
                                tagName="span"
                                className="blockspare-unit"
                                value={priceUnit}
                                style={{
                                    color:priceUnitColor?priceUnitColor:"#af0000"
                                }}
                            />


                        </div>
                    </div>
                    <RichText.Content
                        tagName="p"
                        className="blockspare-description"
                        value={priceDescription}
                        style={{
                            color:priceDescriptionColor?priceDescriptionColor:"#6d6d6d"
                        }}
                    />
                </div>
            </div>
        )
    }


}