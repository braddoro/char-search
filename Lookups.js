isc.defineClass("Lookups", "myWindow").addProperties({
	canDragResize: true,
	height: "*",
	name: "Lookups",
	parent: this,
	title: "Lookups",
	width: 300,
	// width: "33%",
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
			showEdges: true,
			autoFetchData: true,
			// autoFitData: "both",
			childLeft: (this.left + this.width),
			childTop: (this.top),
			// childLeft: 25,
			// childTop: 25,
			dataSource: this.lookupDS,
			groupByField: "lookupName",
			groupStartOpen: "none",
			height: "*",
			ID: "lookupLG",
			parent: this,
			showFilterEditor: true,
			showGroupSummary: true,
			width: 300,
			resized: function(){
				this.childLeft = (this.left + this.width);
				this.childTop = (this.top);
			},
			recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
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
