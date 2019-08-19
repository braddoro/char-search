isc.defineClass("Items", "myWindow").addProperties({
	canDragResize: true,
	height: 690,
	left: 20,
	name: "Items",
	overflow: "auto",
	parent: this,
	title: "Items",
	top: 20,
	width: 1300,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.itemDS = isc.myDataSource.create({
			dataURL: "Items.php",
			ID: "itemDS",
			fields:[
				{name: "itemID", primaryKey: true, detail: true},
				{name: "class", valueMap:["Skill","Technique","Advantage","Equipment"], width: 80},
				{name: "source", detail: true},
				{name: "item_name", width: "*"},
				{name: "itemType", width: 150},
				{name: "specialization", width: 100},
				{name: "canonical_name", detail: true},
				{name: "points", width: 50},
				{name: "reference", width: 50},
				{name: "difficulty", width: 50},
				{name: "type", width: 50},
				{name: "base_points", type: "integer", width: 50},
				{name: "quantity", detail: true},
				{name: "tech_level", detail: true},
				{name: "legality_class", width: 50},
				{name: "value", width: 50},
				{name: "levels", detail: true},
				{name: "cr", width: 50},
				{name: "points_per_level", width: 50},
				{name: "weight", width: 50},
				{name: "notes", width: 50, detail: true},
				{name: "long_description", detail: true}
			]
		});
		this.defaultDS = isc.myDataSource.create({
			dataURL: "Defaults.php",
			ID: "defaultDS",
			fields:[
				{name: "defaultID", primaryKey: true, detail: true},
				{name: "itemID_fk", detail: true},
				{name: "type", width: 100},
				{name: "name"},
				{name: "modifier", width: 100},
				{name: "specialization", width: 200}
			]
		});
		this.prerequisiteDS = isc.myDataSource.create({
			dataURL: "Prerequisite.php",
			ID: "prerequisiteDS",
			fields:[
				{name: "prerequisiteID", primaryKey: true, detail: true},
				{name: "itemID_fk", detail: true},
				{name: "class", width: 100},
				{name: "name"},
				{name: "specialization", width: 100},
				{name: "notes", width: 100}
			]
		});
		this.bonusDS = isc.myDataSource.create({
			dataURL: "Bonuses.php",
			ID: "bonusDS",
			fields:[
				{name: "bonusID", primaryKey: true, detail: true},
				{name: "itemID_fk", detail: true},
				{name: "class", width: 100},
				{name: "name"},
				{name: "specialization", width: 100},
				{name: "amount", width: 100},
				{name: "attribute", width: 100}
			]
		});
		this.modifierDS = isc.myDataSource.create({
			dataURL: "Modifiers.php",
			ID: "modifierDS",
			fields:[
				{name: "modifierID", primaryKey: true, detail: true},
				{name: "itemID_fk", detail: true},
				{name: "name"},
				{name: "affects", width: 100},
				{name: "reference", width: 100},
				{name: "notes", width: 100}
			]
		});
		this.itemLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: this.itemDS,
			height: 250,
			ID: "itemLG",
			parent: this,
			showFilterEditor: true,
			rowClick: function(record, recordNum, fieldNum, keyboardGenerated){
				this.parent.defaultLG.fetchData({itemID_fk: record.itemID});
				this.parent.prerequisiteLG.fetchData({itemID_fk: record.itemID});
				this.parent.bonusLG.fetchData({itemID_fk: record.itemID});
				this.parent.modifierLG.fetchData({itemID_fk: record.itemID});
				var title2 = record.class + ' :: ' + record.itemName;
				if(record.reference > ""){
					title2 += ' :: ' + record.reference;
				}
				var note = "No items to show.";
				if(record.notes > ""){
					note = record.notes;
				}
				this.parent.NoteDF.setValue("detail", note);
			}
		});
		this.defaultLG = isc.myListGrid.create({
			dataSource: this.defaultDS,
			ID: "defaultLG"
		});
		this.prerequisiteLG = isc.myListGrid.create({
			dataSource: this.prerequisiteDS,
			ID: "prerequisiteLG"
		});
		this.bonusLG = isc.myListGrid.create({
			dataSource: this.bonusDS,
			ID: "bonusLG"
		});
		this.modifierLG = isc.myListGrid.create({
			dataSource: this.modifierDS,
			ID: "modifierLG"
		});
		this.NoteDF = isc.DynamicForm.create({
			canDragResize: true,
			canEdit: false,
			height: 120,
			numCols: 1,
			parent: this,
			titleOrientation: "none",
			width: "100%",
			fields: [{name: "detail", type: "textArea", height: "100%", width: "100%"}]
		});

		// this.mainLB = isc.myLabel.create({contents: "<br /><bold><h2>Search</h2></bold>"});
		this.ItemLB = isc.myLabel.create({contents: "<br /><bold><h3>Items</h3></bold>"});
		this.DefaultLB = isc.myLabel.create({contents: "<br /><bold><h3>Defaults</h3></bold>"});
		this.BonusLB = isc.myLabel.create({contents: "<br /><bold><h3>Bonuses</h3></bold>"});
		this.PrerequisiteLB = isc.myLabel.create({contents: "<br /><bold><h3>Prerequisites</h3></bold>"});
		this.ModifierLB = isc.myLabel.create({contents: "<br /><bold><h3>Modifiers</h3></bold>"});
		this.DetailLB = isc.myLabel.create({contents: "<br /><bold><h3>Details</h3></bold>"});

		this.PageLayout = isc.VLayout.create({
			margin: 4,
			parent: this,
			height: "*",
			members: [
				isc.VLayout.create({
					margin: 4,
					parent: this,
					members: [
						// this.mainLB,
						this.ItemLB,
						this.itemLG,
						this.DefaultLB,
						this.defaultLG,
						this.BonusLB,
						this.bonusLG,
						this.PrerequisiteLB,
						this.prerequisiteLG,
						this.ModifierLB,
						this.modifierLG,
						this.DetailLB,
						this.NoteDF
					],
				})
			]
		});
		this.addMember(this.PageLayout);
		this.itemLG.filterData({class: "Skill"});
	}
});
