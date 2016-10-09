//主组件
var MainBox=React.createClass({
	getInitialState:function(){
		return ({
				data:[
				{"id":1,"name":"前端开发1班","num":33,"teacher":"李老师","time":"2016-12-12"},
				{"id":2,"name":"JAVA开发1班","num":63,"teacher":"李老师","time":"2016-12-12"},
				{"id":3,"name":"JAVA开发3班","num":23,"teacher":"李老师","time":"2016-12-12"},
				],
				allChecked:false		//是否为全选状态
			})
	},
	//选择行
	handleSelectRow:function(id){
		var data=this.state.data;
		for (var i in data){
			if (data[i].id == id){
				data[i].selected = data[i].selected === 1 ? 0 :1;
				break;
			}
		}
		this.setState({data},function(){
			this.handleAllChecked();
		});
	},
	//删除行
	handleDeleteRow:function(id){
		var data=this.state.data;
		var data=data.filter(function(item){
			return item.id != id;
		});
		this.setState({data},function(){
			this.handleAllChecked();
		});
	},
	//添加行数据
	handleAddRow:function(obj){
		var data=this.state.data;
		data= data.concat([obj]);
		this.setState({data},function(){
			this.handleAllChecked();
		});
	},
	//是否被全选
	handleAllChecked:function(){
		var allChecked=false;
		var data = this.state.data;
		var selectData=data.filter(function(item){
			return item.selected;
		})
		if (data.length && data.length === selectData.length){
			allChecked=true;
		}
		this.setState({allChecked:allChecked});
	},
	//全选，反全选，反选
	handleAllSelected:function(state){
		var k=0;
		var data=this.state.data.map(function(item){
			if (typeof(state) === "boolean"){
				item.selected =state ? 1 : 0;
			}else{
				//反选
				item.selected =item.selected ? 0 : 1;
				if (item.selected){
					k++;
				}
			}
			return item;
		});
		if (data.length && data.length ==k){
			state=true;
		}
		this.setState({data},function(){
			this.setState({allChecked:state});
		})
	},
	render:function(){
		return (
			<div>
				<h2>ReactJS实例·班级信息表</h2>
				<div>
					<DataList 
						data={this.state.data}
						select={this.handleSelectRow}
						delete={this.handleDeleteRow}
						allChecked={this.state.allChecked}
						allSelected={this.handleAllSelected}
						/>
					<AddList 
						add={this.handleAddRow} 
						/>
				</div>
			</div>
		)
	}
});

//数据列表组件
var DataList=React.createClass({
	onChange:function(){
		var checked=this.props.allChecked ? false : true ;
		this.props.allSelected(checked);
	},
	onMouseUp:function(event){
		if (event.button===2){
			this.props.allSelected();
		}
	},
	onContextMenu:function(event){
		event.preventDefault();
		return false;
	},
	render:function(){
		var checked = this.props.allChecked;
		var datalist=this.props.data.map(function(item){
			return (
				<DataRow
					id={item.id}
					name={item.name}
					num={item.num}
					teacher={item.teacher}
					time={item.time}
					selected={item.selected}
					select={this.props.select}
					delete={this.props.delete}
				/>
			)
		},this);
		return (
			<ul onContextMenu={this.onContextMenu} onMouseUp={this.onMouseUp}>
				<li>
					<div><input type="checkbox" checked={checked} onChange={this.onChange} /></div>
					<div><span>班级名称</span></div>
					<div><span>学员人数</span></div>
					<div><span>指导员</span></div>
					<div><span>建班时间</span></div>
					<div>操作</div>
				</li>
				{datalist}
			</ul>
		)
	}
});
//行组件
var DataRow=React.createClass({
	onChange:function(){
		this.props.select(this.props.id);
	},
	delOnClick:function(){
		if (window.confirm("确定要删除 "+ this.props.name +" 吗?")){
			this.props.delete(this.props.id);
		}
	},
	render:function(){
		var checked=false;
		var rowStyle={};
		if (this.props.selected){
			checked=true;
			rowStyle={background:"#EEE"};
		}
		return (
			<li style={rowStyle}>
				<div><input type="checkbox" checked={checked} onChange={this.onChange} /></div>
				<div><span>{this.props.name}</span></div>
				<div><span>{this.props.num}人</span></div>
				<div><span>{this.props.teacher}</span></div>
				<div><span>{this.props.time}</span></div>
				<div><a href="javascript:;" onClick={this.delOnClick}>删除</a></div>
			</li>
		)
	}
});

//数据添加组件
var AddList = React.createClass({
	refValue:function(ref){
		return ReactDOM.findDOMNode(this.refs[ref]).value.trim();
	},
	refObj:function(ref){
		return ReactDOM.findDOMNode(this.refs[ref]);
	},
	addList:function(){
		var obj={
			id: Math.floor(Math.random()*9999)+1000,
			name: this.refValue('name'),
			num: this.refValue('num'),
			teacher: this.refValue('teacher'),
			time: this.refValue('time'),
		}
		if (!obj.name){
			this.refObj("name").focus();
			return ;
		}
		this.props.add(obj);
		var Refs=["name","num","teacher","time"];
		for (var i=0; i<Refs.length;i++){
			this.refObj(Refs[i]).value="";
		}
		this.refObj("name").focus();
	},
	render:function(){
		return (
			<ol>
				<li><label><u>班级名称：</u><input type="text" ref="name" /></label></li>
				<li><label><u>学员人数：</u><input type="text" ref="num" /></label></li>
				<li><label><u>指导员：</u><input type="text" ref="teacher" /></label></li>
				<li><label><u>建班时间：</u><input type="text" ref="time" /></label></li>
				<li><u></u><button onClick={this.addList}>添加班级信息</button></li>
			</ol>
		)
	}
});
ReactDOM.render(
	<MainBox />,
	document.getElementById("demo")
)
