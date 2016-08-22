/*
* post request and returning value from api
*/

var HandelUrlForm = React.createClass({
	
	p_sendDb: function(v_sUrl, v2_oVal) {
		
		var sParam = 'Url='+v2_oVal;
		var request = new XMLHttpRequest();

		request.open('POST', v_sUrl, false);
		
		request.setRequestHeader(
			"Content-type", "application/x-www-form-urlencoded"
		);

		request.send(sParam);
		
		var sfullpath =  JSON.parse(
			request.response
		).service;

		var r_oGetUrl = (
			v2_oVal.indexOf(window.location.hostname) === -1
		) ? sfullpath.short_url : sfullpath.full_url;
		
		return r_oGetUrl;
	},

	AuthState: function() {

		var mReq = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
 
		if (!mReq .test(this.refs.url_value.value.toLowerCase()) ) {
			
			return true;
		}

	},

	getInitialState: function () {
		
		return { text: null}
	},
	
	clickHandler: function () {
		this.init(event, true);
	},

	init: function(event, bBtn) {
		
		if (event.keyCode === 13 || bBtn) {
			
			var sUrl = this.p_sendDb(
				'api.php', this.refs.url_value.value
			); 

			var r_oState = (
				this.AuthState()
			) ? 
			
			this.setState(
				{ text: 'A valid url is required' }
			) : 

			this.setState(
			{ text: 
				<a href= { sUrl } > { sUrl } </a>
			});
				
			this.refs.url_value.value = '';

			return r_oState; 
		}
	},

	render: function() { 
		
		return (
			<div>
				
				<p> { this.state.text } </p>
				
				<input type="text" 
					ref="url_value" 
					onKeyDown={this.init} 
					placeholder='Url Goes here' 
					autoFocus='true'  
				/>
				
				<input type="button" 
					ref="btn_value"
					value="Get Url"
					onClick={this.clickHandler} 
				/>

			 </div>
		);
	}
});

ReactDOM.render(<HandelUrlForm />, document.getElementById('RenderFields'));