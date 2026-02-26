PROGRAM PrintName(INPUT, OUTPUT);
USES
  DOS;

VAR
  QueryString: STRING;

FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
  PosStr, PosEnd: INTEGER;
  Str: STRING;
BEGIN
  Str := '';

  PosStr := Pos(Key, QueryString);
  IF (PosStr = 1) OR (PosStr = (Pos('?', QueryString) + 1)) OR (PosStr = (Pos('&', QueryString) + 1))
  THEN
    BEGIN
      Delete(QueryString, 1, PosStr + Length(Key) - 1);
      PosStr := Pos('&', QueryString);
      IF PosStr > 0
      THEN
        BEGIN
          Str := Copy(QueryString, 1, PosStr - 1);
          Delete(QueryString, 1, PosStr)
        END
      ELSE
        BEGIN
          PosStr := Pos('?', QueryString);
          IF PosStr > 0
          THEN
            BEGIN
              Str := Copy(QueryString, 1, PosStr - 1);
              Delete(QueryString, 1, PosStr)
            END
          ELSE
            Str := Copy(QueryString, 1, Length(QueryString))
        END
    END;

  GetQueryStringParameter := Str
END;

BEGIN
  QueryString := GetEnv('QUERY_STRING');

  WRITELN('Content-Type: text/html');
  WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name='));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name='));
  WRITELN('Age: ', GetQueryStringParameter('age='))
END.
