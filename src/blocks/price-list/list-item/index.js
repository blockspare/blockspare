import './styles/editor.scss';
import './styles/style.scss';
import marginPadding from '../../utils/attributes/margin-padding';
import  metadata from './block.json';
import Edit from './Edit'
import Save from './Save';
import boxShadowAttributes from "../../utils/attributes/box-shadow";

const {__} = wp.i18n
const {registerBlockType} = wp.blocks;

const {category} = metadata;
const attributes ={
    ...metadata.attributes,
    ...marginPadding,
    ...boxShadowAttributes
}

export const priceListItemSettings = {
    title: __('Price List Item', 'blockspare'),
    description: __('Display creative Price List, Menu .', 'blockspare'),
    parent: ['blockspare/blockspare-price-list'],
    icon: 'link',
    category,
    supports: {
        html: false,
        inserter: false,
        reusable: false,
    },
    attributes,

    edit: Edit,
    save: Save
};

registerBlockType('blockspare/list-item', priceListItemSettings);