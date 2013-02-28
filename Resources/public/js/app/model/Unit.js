Ext.define('WebitCommonUnit.model.Unit',{
	extend: 'Ext.data.Model',
	fields: [{
		name: 'id'
	},{
		name: 'measure',
		type: 'string'
	},{
		name: 'label',
		type: 'string'
	},{
		name: 'symbol',
		type: 'string'
	},{
		name: 'code',
		type: 'string'
	},{
		name: 'full_symbol',
		persist: false
	}],
	proxy : {
		type : 'webitrest',
		appendId : false,
		urlSelector : Webit.data.proxy.StoreUrlSelector('webit_common_unit.extjs_unit_store'),
		reader: {
      type: 'json',
      root: 'data',
      successProperty : 'success',
      totalProperty : 'total',
      idProperty : 'id'
    },
    writer : {
    	type : 'json',
    	writeAllFields : true,
    	allowSingle : false
    }
	}
});
