Ext.define('WebitCommonUnit.store.UnitStore',{
	extend: 'Ext.data.Store',
	model: 'WebitCommonUnit.model.Unit',
	groupField: 'measure',
	remoteSort: false,
	remoteFilter: false,
	remoteGroup: false,
	sorters: [{
		property: 'measure',
		direction: 'ASC'
	},{
		property: 'label',
		direction: 'ASC'
	}]
});
