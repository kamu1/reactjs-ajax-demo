//主组件
var MainBox=React.createClass({
	getInitialState:function(){
		return ({
				data:[
				{"id":1,"name":"前端开发1班","num":33,"teacher":"李老师","time":"2016-12-12"},
				{"id":2,"name":"JAVA开发1班","num":63,"teacher":"李老师","time":"2016-12-12"},
				{"id":3,"name":"JAVA开发3班","num":23,"teacher":"李老师","time":"2016-12-12"},
				]
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
		this.setState({data});
	},
	//删除行
	handleDeleteRow:function(id){
		var data=this.state.data;
		var data=data.filter(function(item){
			return item.id != id;
		});
		this.setState({data});
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
						/>
				</div>
			</div>
		)
	}
});

//数据列表组件
var DataList=React.createClass({
	render:function(){
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
			<ul>
				<li>
					<div></div>
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
ReactDOM.render(
	<MainBox />,
	document.getElementById("demo")
)
