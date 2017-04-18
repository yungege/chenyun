define("common:widget/view/render.js",function(e,t){var i=e("common:widget/lib/three.js"),s=function(e){this.renderEle=e.renderEle,this.geometry=e.geometry,this.renderType=e.renderType,this.debug=e.debug,this.setParams=e.setParams,this.screenshot=e.screenshot,this.init()};s.prototype={declare:function(){this.bgColor=16053492,this.cameraPosX=500,this.cameraPosY=-500,this.cameraPosZ=300,this.fogColor=16053492,this.fogPercent=.007,this.skyColor=16777215,this.spotLightColor=16777215,this.pointLightCOlor=16772863,this.planeColor=8947848,this.modelColor=622494,this.specularColor=0,this.wireframeColor=15658734,this.models=[],this.scale=1,this.renderer=null,this.scene=null,this.camera=null,this.reflectCamera=null,this.plane=null,this.wirePlane=null,this.controls=null,this.deallocate=[]},destroy:function(){for(var e=0;e<this.deallocate.length;e++)this.scene.remove(this.deallocate[e])},set:function(){if("object"==typeof this.setParams)for(var e in this.setParams)this[e]&&"function"!=typeof this[e]&&(this[e]=this.setParams[e])},init:function(){this.declare(),this.set(),this.initScene(),this.renderModel()},renderStlModel:function(){var e=new i.THREE.MeshPhongMaterial({color:this.modelColor,specular:this.specularColor,shading:i.THREE.SmoothShading,shininess:6,fog:!1,side:i.THREE.DoubleSide}),t=new i.THREE.Mesh(this.geometry,e);t.geometry.computeBoundingBox();var s=t.geometry.boundingBox.max.clone().sub(t.geometry.boundingBox.min);maxDim=Math.max(Math.max(s.x,s.y),s.z),this.scale=100/maxDim,this.deallocate.push(e),this.deallocate.push(t),this.deallocate.push(s),t.position.x=-(t.geometry.boundingBox.min.x+t.geometry.boundingBox.max.x)/2*this.scale,t.position.y=-(t.geometry.boundingBox.min.y+t.geometry.boundingBox.max.y)/2*this.scale,t.position.z=-t.geometry.boundingBox.min.z*this.scale,this.scene.add(t),this.models.push(t);for(var o=0;o<this.models.length;o++)this.models[o].scale.x=this.models[o].scale.y=this.models[o].scale.z=this.scale;this.plane.scale.x=this.plane.scale.y=this.plane.scale.z=this.scale,this.centerCamera()},renderObjModel:function(){this.renderStlModel.call(this)},renderModel:function(){switch(this.renderType){case"stl":this.renderStlModel();break;case"obj":this.renderObjModel();break;default:throw new Error("unkonw type")}},startRender:function(){var e=Date.now();this.timeElapsed=void 0==this.lastRenderTime?0:e-this.lastRenderTime,this.lastRenderTime=e,this.controls.dirty=!1,this.controls.update(this.timeElapsed),this.reflectCamera.position.z=-this.camera.position.z,this.reflectCamera.position.y=this.camera.position.y,this.reflectCamera.position.x=this.camera.position.x,this.scene.traverse(function(e){("plane"==e.name||"planewire"==e.name)&&(e.visible=!1),"skybox"==e.name&&(e.visible=!0)}),this.reflectCamera.updateCubeMap(this.renderer,this.scene),this.scene.traverse(function(e){("plane"==e.name||"planewire"==e.name)&&(e.visible=!0),"skybox"==e.name&&(e.visible=!1)}),this.renderer.render(this.scene,this.camera)},initScene:function(){var e=parseInt(this.renderEle.css("width"),10),t=parseInt(this.renderEle.css("height"),10);this.renderEle.html(""),this.scene=new i.THREE.Scene,this.scene.fog=new i.THREE.FogExp2(this.fogColor,this.fogPercent),this.camera=new i.THREE.PerspectiveCamera(37.8,e/t,1,1e5),this.camera.position.set(this.cameraPosX,this.cameraPosY,this.cameraPosZ),this.camera.up=new i.THREE.Vector3(0,0,1),this.controls=new i.THREE.NormalControls(this.camera,this.renderEle[0]),this.reflectCamera=new i.THREE.CubeCamera(.1,5e3,512),this.scene.add(this.reflectCamera),this.initAxis(),this.initSkyBox(),this.initGround(),this.initLight(),this.renderer=this.screenshot?new i.THREE.WebGLRenderer({preserveDrawingBuffer:!0}):new i.THREE.WebGLRenderer,this.renderer.setSize(e,t),this.renderer.setClearColor(this.bgColor),this.renderer.setPixelRatio(window.devicePixelRatio),this.renderEle.append(this.renderer.domElement)},initLight:function(){var e=new i.THREE.SpotLight(this.spotLightColor,.7,0);e.position.set(400,400,400),e.castShadow=!1,this.scene.add(e),this.deallocate.push(e);var t=new i.THREE.SpotLight(this.spotLightColor,.7,0);t.position.set(-400,400,400),t.castShadow=!1,this.scene.add(t),this.deallocate.push(t);var s=new i.THREE.SpotLight(this.spotLightColor,.7,0);s.position.set(-400,-400,400),s.castShadow=!1,this.scene.add(s),this.deallocate.push(s);var o=new i.THREE.SpotLight(this.spotLightColor,.7,0);o.position.set(400,-400,400),o.castShadow=!1,this.scene.add(o),this.deallocate.push(o);var n=new i.THREE.PointLight(this.pointLightCOlor,.7,0);if(n.position.set(0,0,-400),this.scene.add(n),this.deallocate.push(n),this.debug){var a=new i.THREE.SpotLightHelper(e);this.scene.add(a),this.deallocate.push(a);var r=new i.THREE.SpotLightHelper(t);this.scene.add(r),this.deallocate.push(r);var h=new i.THREE.SpotLightHelper(s);this.scene.add(h),this.deallocate.push(h)}},initGround:function(){var e=new i.THREE.MeshPhongMaterial({color:this.planeColor,wireframe:!1,envMap:this.reflectCamera.renderTarget}),t=1600,s=1600,o=Math.floor(t/10),n=Math.floor(s/10);if(this.plane=new i.THREE.Mesh(new i.THREE.PlaneGeometry(t,s,o,n),e),this.plane.name="plane",this.plane.receiveShadow=!0,this.scene.add(this.plane),this.deallocate.push(e),this.deallocate.push(this.plane),this.debug){var a=this.plane.clone(),r=a.geometry.faces,h=a.geometry.vertices,l=new i.THREE.Geometry,c=["a","b","c","d"];r.forEach(function(e){if(e instanceof i.THREE.Face3){var t=h[e[c[0]]],s=h[e[c[1]]],o=h[e[c[2]]],n=t.distanceTo(s),a=t.distanceTo(o),r=o.distanceTo(s);n>a&&n>r?(l.vertices.push(t),l.vertices.push(o),l.vertices.push(s),l.vertices.push(o)):a>r?(l.vertices.push(t),l.vertices.push(s),l.vertices.push(o),l.vertices.push(s)):(l.vertices.push(t),l.vertices.push(s),l.vertices.push(o),l.vertices.push(t))}});var d=new i.THREE.LineBasicMaterial({color:this.wireframeColor,linewidth:2,side:2,overdraw:.5}),m=new i.THREE.Line(l,d,i.THREE.LinePieces);this.plane.add(m),this.deallocate.push(d),this.deallocate.push(m)}},initSkyBox:function(){var e=new i.THREE.MeshPhongMaterial({color:this.skyColor,emissive:this.skyColor,shading:i.THREE.SmoothShading,fog:!1,side:i.THREE.BackSide}),t=new i.THREE.Mesh(new i.THREE.BoxGeometry(1e3,1e3,1e3),e);t.name="skybox",this.scene.add(t),this.deallocate.push(e),this.deallocate.push(t)},initAxis:function(){if(!this.debug)return!1;var e=new i.THREE.AxisHelper(400);this.scene.add(e)},centerCamera:function(){var e=void 0,t=0,s=new i.THREE.Box3;this.scene.traverse(function(o){if(o instanceof i.THREE.Mesh){if("skybox"==o.name||"plane"==o.name||"planewire"==o.name)return;t+=1,o.geometry.computeBoundingBox(),o.geometry.boundingBox.min.applyMatrix4(o.matrixWorld),o.geometry.boundingBox.max.applyMatrix4(o.matrixWorld),o.geometry.boundingBox.min.x+=o.position.x,o.geometry.boundingBox.min.y+=o.position.y,o.geometry.boundingBox.min.z+=o.position.z,o.geometry.boundingBox.max.x+=o.position.x,o.geometry.boundingBox.max.y+=o.position.y,o.geometry.boundingBox.max.z+=o.position.z;var n=o.geometry.boundingBox.center();if(n.z/=2,s.min.x=Math.min(s.min.x,o.geometry.boundingBox.min.x),s.min.y=Math.min(s.min.y,o.geometry.boundingBox.min.y),s.min.z=Math.min(s.min.z,o.geometry.boundingBox.min.z),s.max.x=Math.max(s.max.x,o.geometry.boundingBox.max.x),s.max.y=Math.max(s.max.y,o.geometry.boundingBox.max.y),s.max.z=Math.max(s.max.z,o.geometry.boundingBox.max.z),void 0===e)a=n.clone();else{var a=new i.THREE.Vector3;a.sub(n,e),a.divideScalar(t+1),a.add(e)}e=a}}),this.controls.desiredCameraTarget=e,this.controls.desiredCameraTarget.x=this.controls.desiredCameraTarget.y=0;var o=(s.max.x-s.min.x)/2/Math.tan(this.controls.camera.fov*this.controls.camera.aspect*Math.PI/360),n=(s.max.y-s.min.y)/2/Math.tan(this.controls.camera.fov*this.controls.camera.aspect*Math.PI/360),a=(s.max.z-s.min.z)/2/Math.tan(this.controls.camera.fov*Math.PI/360),r=Math.max(Math.max(o,n),a);r*=1.7*this.scale;var h=this.controls.target.clone().sub(this.camera.position).normalize().multiplyScalar(r);this.controls.desiredCameraPosition=e.clone().sub(h),this.controls.maxDistance=10*r}},t.render=s});