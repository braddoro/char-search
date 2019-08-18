isc.defineClass("Lookups", "myWindow").addProperties({
	canDragResize: true,
	height: "95%",
	name: "Lookups",
	parent: this,
	title: "Lookups",
	width: "33%",
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
			// showEdges: true,
			autoFetchData: true,
			dataSource: this.lookupDS,
			groupByField: "lookupName",
			groupStartOpen: "none",
			height: "110%",
			ID: "lookupLG",
			parent: this,
			autoFitData: "both",
			showFilterEditor: true,
			showGroupSummary: true,
			width: "110%",
			childLeft: (this.left + this.width),
			childTop: (this.top + 25),
			recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
				// var detail;
				var title2 = record.category + ' :: ' + record.itemName;
				if(record.lookupRef > ""){
					title2 += ' :: ' + record.lookupRef;
				}
				if(record.itemDetail > ""){
					// detail = record.itemDetail.replace(/(["<br/>"])\w+/, "\r\n")
					isc.ShowInfo.create({title: title2, info: record.itemDetail, left: this.childLeft, top: this.childTop});
					this.childTop = this.childTop + 25;
					this.childLeft = this.childLeft + 25;
				}
			}
		});
		this.SearchLayoutVL = isc.VLayout.create({
			members: [this.lookupLG]
		});
		this.addMember(this.SearchLayoutVL);
	}
});
