##krigagem.r -> Recebe os parametros e calcula a krigagem, salvando as imagens
library(RGeostats)

## Recebimento de parametros
args <- commandArgs(TRUE)     
tx <- args[1]    
ty <- args[2]
tv <- args[3]
ncel <- as.integer(args[4])
nlag <- as.integer(args[5])
ndir <- as.integer(args[6])
ang <- as.integer(args[7])

## transformar string recebida em vetores de numeros x, y e v
x<-str_split(tx,',')
y<-str_split(ty,',')
v<-str_split(tv,',')


for (i in 1:length(x)){
  x[[i]]<-as.double(x[[i]])
}

for (i in 1:length(y)){
  y[[i]]<-as.double(y[[i]])
}

for (i in 1:length(v)){
  v[[i]]<-as.double(v[[i]])
}

#Criacao db com os dados
rx  <- extendrange(x)
ry  <- extendrange(y)
db.data <- db.create(x=x,y=y,v=v)

#Criacao grid que irá receber os dados
extx <- rx[2] - rx[1]
exty <- ry[2] - ry[1]
diam <- sqrt(extx * extx + exty * exty)
db.grid <- db.create(flag.grid=TRUE,x0=c(rx[1],ry[1]),
                     nx=c(ncell,ncell),dx=c(extx/ncell,exty/ncell))

#Criacao da vizinhanca
test.neigh <- neigh.create(ndim=2,type=0)

dirvect <- (seq(1,ndir)-1) * 180 / ndir + ang

# Calcula o variograma experimental e o ajuste automático
test.vario <- vario.calc(db.data,dirvect=dirvect,lag=diam/(2*nlag),nlag=nlag)
test.model <- model.auto(test.vario,draw=FALSE)

# Executa o Kriging
db.grid <- kriging(db.data,db.grid,test.model,test.neigh)


#Gera imagens para apresentar

#Variograma
png(filename="variograma.png", width=600, height=400)
plot(test.vario,reset=FALSE,title="Variogram Model")
plot(test.model,add=T)
dev.off()
