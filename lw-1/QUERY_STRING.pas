PROGRAM PrintName(INPUT, OUTPUT);
USES
  DOS;

VAR
  QueryString: STRING;

FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
  Pos: INTEGER;
  Str: STRING;
BEGIN
  Pos := Pos(Key, QueryString);

  IF Pos > 0 
  THEN
    Delete(QueryString, 1, Pos + Length(Key));
    Pos := Pos('&', QueryString);
    IF Pos > 0 
    THEN 
      BEGIN
        Str := Copy(QueryString, 1, Pos - 1);
        Delete(QueryString, 1, Pos)
      END
    ELSE
      Str := Copy(QueryString, 1, Length(QueryString));

  GetQueryStringParameter := Str;  

END;

BEGIN
  QueryString := GetEnv('QUERY_STRING');
  
    
  WRITELN('Content-Type: text/html');
  WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age: ', GetQueryStringParameter('age'))
END.
