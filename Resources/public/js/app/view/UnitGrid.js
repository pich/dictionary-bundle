Ext.define('WebitCommonUnit.view.UnitGrid',{
	extend: 'Webit.view.grid.EditableGrid',
	alias: 'widget.webit_common_unit_unit_grid',
	requires: [
		'WebitCommonUnit.view.Format'
	],
	initComponent: function() {
		Ext.apply(this,{
			editmode: 'row',
			features: [{
				ftype: 'grouping',
				hideGroupedHeader: true
			}],
			columns: [{
				header: 'Miara',
				dataIndex: 'measure',
				width: 130,
				renderer: WebitCommonUnit.view.Format.measureRenderer(),
				editor: {
					xtype: 'combo',
					queryMode: 'local',
					allowBlank: false,
					store: 'WebitCommonUnit.store.MeasureStore',
					displayField: 'label',
					valueField: 'id',
					forceSelection: true,
					editable: false
				}
			},{
				header: 'Nazwa',
				dataIndex: 'label',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				},
				width: 150
			},{
				header: 'Symbol',
				dataIndex: 'symbol',
				width: 80,
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},{
				header: 'Kod',
				dataIndex: 'code',
				flex: 1,
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			}],
			store: {
				model: 'WebitCommonUnit.model.Unit',
				autoSync: true,
				remoteSort: false,
				remoteFilter: false,
				remoteGroup: false,
				sorters: [{
					property: 'measure',
					direction: 'ASC'
				},{
					property: 'label',
					direction: 'ASC'
				}],
				groupField: 'measure'
			}
		});
		
		this.callParent();
	}
});