isc.defineClass("Items", "myWindow").addProperties({
	canDragResize: true,
	left: 20,
	top: 20,
	name: "Items",
	parent: this,
	title: "Items",
	width: 1300,
	height: 690,
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
		// this.detailDS = isc.myDataSource.create({
		// 	dataURL: "Details.php",
		// 	ID: "categoryDS",
		// 	fields:[
		// 		{name: "detailID", primaryKey: true, detail: true},
		// 		{name: "itemID_fk", detail: true},
		// 		{name: "detail"}
		// 	]
		// });

		this.itemLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: this.itemDS,
			height: 250,
			width: 1250,
			ID: "itemLG",
			parent: this,
			showFilterEditor: true,
			rowClick: function(record, recordNum, fieldNum, keyboardGenerated){
				this.parent.defaultLG.fetchData({itemID_fk: record.itemID});
				this.parent.prerequisiteLG.fetchData({itemID_fk: record.itemID});
				this.parent.bonusLG.fetchData({itemID_fk: record.itemID});
				this.parent.modifierLG.fetchData({itemID_fk: record.itemID});
				// this.parent.detailLG.fetchData({itemID_fk: record.itemID});
				var title2 = record.class + ' :: ' + record.itemName;
				if(record.reference > ""){
					title2 += ' :: ' + record.reference;
				}
				if(record.notes > ""){
					this.parent.NoteDF.setValue("detail", record.notes);
				}
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
		// this.detailLG = isc.myListGrid.create({
		// 	dataSource: this.detailDS,
		// 	ID: "detailLG",
		// 	width: 1310
		// });
		this.NoteDF = isc.DynamicForm.create({
			parent: this,
			canDragResize: true,
			canEdit: false,
			height: 120,
			width: "100%",
			numCols: 1,
			titleOrientation: "none",
			fields: [
				{name: "detail", type: "textArea", height: "100%", width: "100%"}
			]
		});

		this.mainLB = isc.myLabel.create({contents: "<bold><h2>Search</h2></bold>"});
		this.ItemLB = isc.myLabel.create({contents: "<bold><h3>Items</h3></bold>"});
		this.DefaultLB = isc.myLabel.create({contents: "<bold><h3>Defaults</h3></bold>"});
		this.BonusLB = isc.myLabel.create({contents: "<bold><h3>Bonuses</h3></bold>"});
		this.PrerequisiteLB = isc.myLabel.create({contents: "<bold><h3>Prerequisites</h3></bold>"});
		this.ModifierLB = isc.myLabel.create({contents: "<bold><h3>Modifiers</h3></bold>"});
		this.DetailLB = isc.myLabel.create({contents: "<bold><h3>Details</h3></bold>"});

		this.PageLayout = isc.VLayout.create({
			margin: 4,
			parent: this,
			height: "*",
			members: [
				isc.VLayout.create({
					margin: 4,
					parent: this,
					members: [
						this.mainLB,
						this.ItemLB,
						this.itemLG,
						isc.HLayout.create({
							parent: this,
							margin: 4,
							members: [
								isc.VLayout.create({
									parent: this,
									margin: 4,
									members: [this.DefaultLB, this.defaultLG]
									}),
								isc.VLayout.create({
									parent: this,
									margin: 4,
									members: [this.BonusLB, this.bonusLG]
								})
							]
						}),
						isc.HLayout.create({
							parent: this,
							margin: 4,
							members: [
								isc.VLayout.create({
									parent: this,
									margin: 4,
									members: [this.PrerequisiteLB, this.prerequisiteLG]
									}),
								isc.VLayout.create({
									parent: this,
									margin: 4,
									members: [this.ModifierLB, this.modifierLG]
								})
							]
						}),
						isc.HLayout.create({
							parent: this,
							margin: 4,
							members: [
								isc.VLayout.create({
									parent: this,
									margin: 4,
									members: [this.DetailLB, this.NoteDF]
									})
							]
						})
					],
				})
			]
		});
		this.addMember(this.PageLayout);
		this.itemLG.filterData({class: "Skill"});
	}
});
