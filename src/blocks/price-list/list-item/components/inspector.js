import BSIconSettings from '../../../icon-set/components/icon-settings';
import Padding from './../../../utils/padding';
import Margin from './../../../utils/margin';
import BoxShadow from "../../../utils/component/boxshadow";
const {__} = wp.i18n;
const {Component} = wp.element;


// Import block components
const {
    InspectorControls,
    PanelColorSettings,
} = wp.blockEditor;

// Import Inspector components
const {
    PanelBody,
    ToggleControl,
    SelectControl,
    RangeControl
} = wp.components;


export default class Inspector extends Component {


    render() {

        const {
            attributes: {
                layoutOptions,
                priceUnitPosition,
                showDots,
                priceTitleColor,
                priceColor,
                priceUnitColor,
                backgroundColor,
                priceDescriptionColor,
                showImage,
                imgIconOption,
                name,
                iconSize,
                iconStyles,
                iconBackgroundColor,
                iconBorderColor,
                iconColor,
                borderRadius,
                paddingTop,
                paddingRight,
                paddingBottom,
                paddingLeft,
                marginTop,
                marginBottom,
                blockBorderRadius,
                enableBoxShadow,
                xOffset,
                yOffset,
                blur,
                spread,
                shadowColor,

            },
            setAttributes

        } = this.props;

        const listLayoutOptions = [
            {value: 'blockspare-layout1', label: __('Layout 1', 'blockspare')},
            {value: 'blockspare-layout2', label: __('Layout 2', 'blockspare')},
            {value: 'blockspare-layout3', label: __('Layout 3', 'blockspare')}
        ];

        const priceUnitPositions = [
            {value: 'blockspare-before-price', label: __('Before Price', 'blockspare')},
            {value: 'blockspare-after-price', label: __('After Price', 'blockspare')},
        ];

        const imgIconOptions = [
            {value:'icon',label:__('Icon','blockspare')},
            {value:'image',label:__('Image','blockspare')}
        ];

        const onChangeTitleColor = value => setAttributes({priceTitleColor: value});
        const onChangeBackgroundColor = value => setAttributes({backgroundColor: value});
        const onChangePriceColor = value => setAttributes({priceColor: value});
        const onChangePriceUnitColor = value => setAttributes({priceUnitColor: value});
        const onChangePriceDotColor = value => setAttributes({priceDotColor: value});
        const onChangePriceDescriptionColor = value => setAttributes({priceDescriptionColor: value});
        const onChangeimgIconOption = value => setAttributes({imgIconOption: value});
        return (
            <InspectorControls>
                <div className="blockspare-inspector-wrapper">
                    <PanelBody
                        title={__('Block Settings', 'blockspare')}
                        initialOpen={false}
                    >

                    <ToggleControl
                        label={__('Display Image ', 'blockspare')}
                        checked={showImage}
                        onChange={() => this.props.setAttributes({showImage: !showImage})}
                    />

                    {imgIconOption == 'icon' && showImage &&
                    <PanelBody title={__('Icon Settings')} initialOpen={true}>

                        <BSIconSettings
                            name={name}
                            onChangeName={name => setAttributes({name})}

                            enableiconSize={true}
                            iconSize={iconSize}
                            onChangeIconSizeOptions={iconSize => setAttributes({iconSize})}

                            enableiconStyles={true}
                            iconStyles={iconStyles}
                            onChangeIconStyles={iconStyles => setAttributes({iconStyles})}

                            iconBackgroundColor={iconBackgroundColor}
                            onChangeIconBackgroundColor={iconBackgroundColor => setAttributes({iconBackgroundColor})}

                            iconBorderColor={iconBorderColor}
                            onChangeIconBorderColor={iconBorderColor => setAttributes({iconBorderColor})}

                            iconColor={iconColor}
                            OnChangeIconColor={iconColor => setAttributes({iconColor})}

                            borderRadius={borderRadius}
                            onChangeBorderRadius={borderRadius => setAttributes({borderRadius})}

                        />
                    </PanelBody>
                    }

                    <ToggleControl
                        label={__('Display Dots', 'blockspare')}
                        checked={showDots}
                        onChange={() => this.props.setAttributes({showDots: !showDots})}
                    />

                </PanelBody>
                <PanelBody
                    title={__('Color Settings', 'blockspare')}
                    initialOpen={false}
                >
                    <PanelColorSettings
                        title={__('Colors', 'blockspare')}
                        initialOpen={true}
                        colorSettings={[

                            {
                                value: priceColor,
                                onChange: onChangePriceColor,
                                label: __('Price Color', 'blockspare'),
                            },
                            {
                                value: priceUnitColor,
                                onChange: onChangePriceUnitColor,
                                label: __('Unit Color', 'blockspare'),
                            }


                        ]}
                    >
                    </PanelColorSettings>

                </PanelBody>

                <PanelBody
                    title={__('Block Gap', 'blockspare')}
                    initialOpen={false}
                >
                    <PanelBody
                        title={__('Padding Settings', 'blockspare')}
                        initialOpen={true}
                    >
                        <Padding

                            // Top padding
                            paddingEnableTop={true}
                            paddingTop={paddingTop}
                            paddingTopMin="0"
                            paddingTopMax="100"
                            onChangePaddingTop={paddingTop => setAttributes({paddingTop})}

                            // Right padding
                            paddingEnableRight={true}
                            paddingRight={paddingRight}
                            paddingRightMin="0"
                            paddingRightMax="100"
                            onChangePaddingRight={paddingRight => setAttributes({paddingRight})}

                            // Bottom padding
                            paddingEnableBottom={true}
                            paddingBottom={paddingBottom}
                            paddingBottomMin="0"
                            paddingBottomMax="100"
                            onChangePaddingBottom={paddingBottom => setAttributes({paddingBottom})}

                            // Left padding
                            paddingEnableLeft={true}
                            paddingLeft={paddingLeft}
                            paddingLeftMin="0"
                            paddingLeftMax="100"
                            onChangePaddingLeft={paddingLeft => setAttributes({paddingLeft})}
                        />
                    </PanelBody>

                    <PanelBody
                        title={__('Margin Settings', 'blockspare')}
                        initialOpen={true}
                    >
                        <Margin

                            // Top padding
                            marginEnableTop={true}
                            marginTop={marginTop}
                            marginTopMin="0"
                            marginTopMax="100"
                            onChangeMarginTop={marginTop => setAttributes({marginTop})}


                            // Bottom margin
                            marginEnableBottom={true}
                            marginBottom={marginBottom}
                            marginBottomMin="0"
                            marginBottomMax="100"
                            onChangeMarginBottom={marginBottom => setAttributes({marginBottom})}


                        />
                    </PanelBody>
                </PanelBody>
                </div>
            </InspectorControls>

        );
    }

}