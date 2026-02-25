PROGRAM PrintName(INPUT, OUTPUT);
USES
  DOS;

VAR
  QueryString, Name: STRING;
  PosName: INTEGER;
BEGIN
  QueryString := GetEnv('QUERY_STRING');
  PosName := Pos('name=', QueryString);

  IF PosName > 0 
  THEN
    BEGIN
      Delete(QueryString, 1, PosName + 4);
      PosName := Pos('&', QueryString);
      IF PosName > 0 
      THEN 
        BEGIN
          Name := Copy(QueryString, 1, PosName - 1);
          Delete(QueryString, 1, PosName)
        END
      ELSE
        Name := QueryString
    END;
  ELSE
    Name := 'Anonymous';

  
  WRITELN(‘HTTP/2 200 Ok’);
  WRITELN('Content-Type: text/html');
  WRITELN;
  WRITELN('Ïðèâåò, ', Name, '!')
END.
