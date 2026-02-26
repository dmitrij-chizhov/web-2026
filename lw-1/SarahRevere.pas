PROGRAM PrintName(INPUT, OUTPUT);
USES
  DOS;

VAR
  QueryString, Lanterns: STRING;
  PosLanterns: INTEGER;
BEGIN
  QueryString := GetEnv('QUERY_STRING');
  PosLanterns := Pos('lanterns=', QueryString);

  IF PosLanterns > 0 
  THEN
    Lanterns := Copy(QueryString, PosLanterns + 9, Lenght(QueryString) - 9);

  WRITELN('Content-Type: text/html');
  WRITELN;

  IF Lenght(Lanterns) = 1
  THEN
    IF Lanterns = '1'
    THEN 
      WRITELN('The British are coming by land.')
    ELSE
      IF Lanterns = '2'
      THEN 
        WRITELN('The British are coming by sea.')
      ELSE
        WRITELN('Sarah didn''t say.')
  ELSE
    WRITELN('Sarah didn''t say.') 

  
END.
