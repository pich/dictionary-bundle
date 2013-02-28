Ext.define('WebitCommonUnit.store.MeasureStore',{
	extend: 'Ext.data.Store',
	reader: {
		type: 'json'
	},
	fields: [{
		name: 'id',
		type: 'string'
	},{
		name: 'label',
		type: 'string'
	}],
	sorters: [{
		property: 'label',
		direction: 'ASC'
	}],
	data: [{
		id: 'length',
		label: 'Długość'
	},{
		id: 'area',
		label: 'Powierzchnia'
	},{
		id: 'volume',
		label: 'Objętość'
	},{
		id: 'mass',
		label: 'Masa'
	},{
		id: 'quantity',
		label: 'Liczność'
	},{
		id: 'other',
		label: 'Inna'
	}]
});
