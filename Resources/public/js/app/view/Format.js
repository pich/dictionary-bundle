/**
 * @class WebitCommonUnit.view.Format
 * 
 * @singleton
 */
Ext.ns('WebitCommonUnit.view');

WebitCommonUnit.view.Format = {};
Ext.apply(WebitCommonUnit.view.Format,{
	measureRenderer: function() {
		return function(v) {
			var store = Ext.getStore('WebitCommonUnit.store.MeasureStore');
			var r = store.getById(v);
			if(r) {
				return r.get('label');
			}
			
			return v;
		}
	}
});
