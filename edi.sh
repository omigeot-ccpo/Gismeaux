 #!/bin/sh
psql -d meaux -h 192.168.200.2 -c "SELECT gm_efface_donnee_schema('test_edigeo')"
 for o in commu*; do
	mkdir $o/SHP
	for i in $o/*.THF; do
#		echo $i
		ogr2ogr -append -f "ESRI Shapefile" $o/SHP $i
	done
	codeinsee=770${o:7:3}
		for p in $o/SHP/*.shp; do
			psql -d meaux -h 192.168.200.2 -c "alter table test_edigeo.${p:15:-4} alter column code_insee set default $codeinsee;"
			shp2pgsql -a -s 310024149 -g the_geom -W LATIN1 -D $p test_edigeo.${p:15:-4} | psql -d meaux -h 192.168.200.2
		done
done