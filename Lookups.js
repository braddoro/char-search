isc.defineClass("Lookups", "myWindow").addProperties({
	canDragResize: true,
	top: 25,
	left: 5,
	height: "*",
	name: "Lookups",
	parent: this,
	title: "Lookups",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.lookupDS = isc.myDataSource.create({
			dataURL: "Lookups.php",
			ID: "lookupDS",
			fields:[
				{name: "lookupID", primaryKey: true, detail: true},
				{name: "category", width: 80},
				{name: "lookupName", width: 80, detail: true},
				{name: "lookupRef", width: 80},
				{name: "itemName", width: "*"},
				{name: "itemRef", width: 80, detail: true},
				{name: "itemDetail", detail: true}
			]
		});
		this.lookupLG = isc.myListGrid.create({
			autoFetchData: true,
			autoFitData: "both",
			childLeft: 360,
			childTop: 30,
			dataSource: this.lookupDS,
			groupByField: "lookupName",
			groupStartOpen: "none",
			height: "*",
			height: "100%",
			ID: "lookupLG",
			parent: this,
			showEdges: true,
			showFilterEditor: true,
			showGroupSummary: true,
			width: "100%",
			recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
				var title2 = record.category + ' :: ' + record.itemName;
				if(record.lookupRef > ""){
					title2 += ' :: ' + record.lookupRef;
				}
				if(record.itemDetail > ""){
					isc.ShowInfo.create({title: title2, info: record.itemDetail, left: this.childLeft, top: this.childTop});
					this.childTop = this.childTop + 20;
					this.childLeft = this.childLeft + 20;
				}
			}
		});
		this.SearchLayoutVL = isc.VLayout.create({
			members: [this.lookupLG]
		});
		this.addMember(this.SearchLayoutVL);
		this.childLeft = (this.left + this.width) + 20;
		this.childTop = (this.top) + 20;
	}
});
