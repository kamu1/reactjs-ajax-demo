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
	render:function(){
		return (
			<div>
				<h2>ReactJS实例·班级信息表</h2>
				<div>
					<DataList 
						data={this.state.data}
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
				/>
			)
		});
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
	render:function(){
		return (
			<li>
				<div><input type="checkbox" /></div>
				<div><span>{this.props.name}</span></div>
				<div><span>{this.props.num}人</span></div>
				<div><span>{this.props.teacher}</span></div>
				<div><span>{this.props.time}</span></div>
				<div><a href="javascript:;">删除</a></div>
			</li>
		)
	}
});
ReactDOM.render(
	<MainBox />,
	document.getElementById("demo")
)
