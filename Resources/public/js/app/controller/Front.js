Ext.define('WebitCommonUnit.controller.Front',{
	extend: 'Ext.app.Controller',
	views: [
		'WebitCommonUnit.view.UnitGrid',
		'WebitCommonUnit.view.UnitCombo',
		'WebitCommonUnit.view.MeasureCombo'
	],
	models: [
		'WebitCommonUnit.model.Unit'
	],
	stores: [
		'WebitCommonUnit.store.MeasureStore',
		'WebitCommonUnit.store.UnitStore'
	],
	init: function() {
		this.control({
			'webit_common_unit_unit_grid': {
				afterrender: function(grid) {
					grid.getStore().load();
				},
				beforeedit: this.beforeUnitEdit,
				edit: this.hideMeasureColumn,
				canceledit: this.hideMeasureColumn
			}
		});
	},
	beforeUnitEdit: function(editor, e, opts) {
		if(e.record.phantom == false) {
			e.grid.columns[0].getEditor().setReadOnly(true);
			e.grid.columns[3].getEditor().setReadOnly(true);
		} else {
			e.grid.columns[0].getEditor().setReadOnly(false);
			e.grid.columns[3].getEditor().setReadOnly(false);
			e.grid.columns[0].setVisible(true);
		}
	},
	hideMeasureColumn: function(editor, e, opts) {
		e.grid.columns[0].setVisible(false);
	}
});
