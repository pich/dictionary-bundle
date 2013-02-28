Ext.define('WebitCommonUnit.view.MeasureCombo',{
	extend: 'Ext.form.ComboBox',
	fieldLabel: 'Miara',
	store: 'WebitCommonUnit.store.MeasureStore',
	valueField: 'id',
	displayField: 'label',
	forceSelection: true,
	editable: false,
	initComponent: function() {
		this.callParent();
	}
});