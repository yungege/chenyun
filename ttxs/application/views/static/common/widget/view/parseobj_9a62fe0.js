define("common:widget/view/parseobj.js",function(e,n){var t=e("common:widget/lib/three.js"),r={parse:function(e){for(var n=/v( +[\d|\.|\+|\-|e|E]+)( +[\d|\.|\+|\-|e|E]+)( +[\d|\.|\+|\-|e|E]+)/,r=/f( +-?\d+)( +-?\d+)( +-?\d+)( +-?\d+)?/,d=/f( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))?/,s=/f( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))?/,p=/f( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))?/,a=e.split("\n"),o=[],u=[],c=0;c<a.length;c++){var l=a[c],h=null;l=l.trim(),0!==l.length&&"#"!==l.charAt(0)&&(null!==(h=n.exec(l))?o.push([parseFloat(h[1]),parseFloat(h[2]),parseFloat(h[3])]):null!==(h=r.exec(l))?u.push([parseInt(h[1]),parseInt(h[2]),parseInt(h[3])]):null!==(h=d.exec(l))?u.push([parseInt(h[2]),parseInt(h[5]),parseInt(h[8])]):null!==(h=s.exec(l))?u.push([parseInt(h[2]),parseInt(h[6]),parseInt(h[10])]):null!==(h=p.exec(l))&&u.push([parseInt(h[2]),parseInt(h[7]),parseInt(h[12])]))}for(var i=new t.THREE.Geometry,c=0;c<u.length;c++){var E,v,g=o[u[c][0]-1],I=o[u[c][1]-1],f=o[u[c][2]-1];try{var w=[g[0],g[1],g[2]],m=[I[0],I[1],I[2]],x=[f[0],f[1],f[2]]}catch(H){console.log(u[c],g,I,f);continue}var R=function(){var e,n,t,r,d,s,p=[],a=0,o=0,u=0;return e=m[0]-w[0],n=m[1]-w[1],t=m[2]-w[2],r=x[0]-w[0],d=x[1]-w[1],s=x[2]-w[2],a=s*n-d*t,o=e*s-r*t,u=e*d-r*n,p.push(a),p.push(o),p.push(u),p};E=R(),v=new t.THREE.Vector3(E[0],E[1],E[2]),i.vertices.push(new t.THREE.Vector3(w[0],w[1],w[2])),i.vertices.push(new t.THREE.Vector3(m[0],m[1],m[2])),i.vertices.push(new t.THREE.Vector3(x[0],x[1],x[2])),length=i.vertices.length,i.faces.push(new t.THREE.Face3(length-3,length-2,length-1,v))}return i.computeBoundingBox(),i.computeBoundingSphere(),i}};n.parseobj=r});