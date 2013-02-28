Ext.define('WebitCommonUnit.view.UnitCombo',{
	extend: 'Ext.form.ComboBox',
	alias: 'widget.webit_common_unit_unit_combo',
	requires: [
		'WebitCommonUnit.view.Format'
	],
	fieldLabel: 'Jednostka',
	store: 'WebitCommonUnit.store.UnitStore',
	valueField: 'full_symbol',
	displayField: 'label',
	forceSelection: true,
	editable: false,
	listConfig: {
    tpl: Ext.create('Ext.XTemplate',
      '<ul><tpl for=".">',
      '<tpl if="xindex == 1 || this.getGroupStr(parent[xindex - 2]) != this.getGroupStr(values)">',
      '<li class="x-combo-list-group"><b>{[this.getGroupStr(values)]}</b></li>',
      '</tpl>',
      '<li role="option" class="x-boundlist-item" style="padding-left: 12px">{label}</li>',
      '</tpl>' +
      '</ul>',
      {
        getGroupStr: function (values) {
        	var r = WebitCommonUnit.view.Format.measureRenderer();
        	return r(values.measure);
        }
      }
    )
  },
	initComponent: function() {
		this.callParent();
	}
});
