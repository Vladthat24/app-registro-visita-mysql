select * from Tap_Entidad;
select * from Tap_Funcionario;
select * from Tap_RegistroVisita;

delete from Tap_RegistroVisita where id in(2053,2054);
delete from Tap_Funcionario where id=1158;

select * into #temp_Tap_Funcionario from Tap_Funcionario;


select * from #temp_Tap_Funcionario;


delete from Tap_Funcionario where id in(1158,1159);


--PROCESO PARA INSERT CARGOAS MASIVAS
SET IDENTITY_INSERT Tap_Funcionario ON;

--inicie el proceso del Asistente de importación y exportación y, una vez que los datos se carguen correctamente 
--ejecute lo siguiente 

SET IDENTITY_INSERT Tap_Funcionario OFF;

--Mostramos id, fecha registro de la Tabla Funcionario
select id,fecha_registro from Tap_Funcionario where id>=1160;

--Obtenermos todos los datos en una tabla temporal
select * into #tmpTap_Funcionario_FechaRegistro from Tap_Funcionario;


--Actualizamos un dato de la tabla funcionarios 
begin tran
update a  
	set a.fecha_registro=convert(varchar,convert(datetime,b.fecha_registro,121),21)
from Tap_Funcionario a 
	inner join 
	#tmpTap_Funcionario_FechaRegistro b on a.id=b.id 
	where a.id>=1160;
commit
rollback

-- Mostramos el formato para verificar que fecha esta correcta
select 
SUBSTRING(fecha_registro,1,len(fecha_registro) -1),
convert(varchar,convert(datetime,fecha_registro,121),21)
from Tap_Funcionario
where id>=1160;

select * from #tmpTap_Funcionario_FechaRegistro